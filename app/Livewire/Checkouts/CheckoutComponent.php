<?php

namespace App\Livewire\Checkouts;

use App\Contracts\PaymentServiceInterface;
use App\Models\Item;
use App\Models\Order;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Livewire\Component;

class CheckoutComponent extends Component
{
    public string $product = "";
    public string $mpesa_number = "";
    public string $customer_name = "";
    public string $town = "";
    public string $description = "";
    public bool $use_as_contact = false;

    // Cart related properties
    public array $cart = [];
    public int $cartTotal = 0;
    public int $cartCount = 0;

    protected PaymentServiceInterface $paymentService;

    protected $listeners = [
        'cart-updated' => 'loadCart',
    ];

    // Form validation rules
    protected $rules = [
        'mpesa_number' => 'required|regex:/^07\d{8}$/',
        'customer_name' => 'required|string|max:100',
        'town' => 'required|string|max:100',
        'description' => 'required|string|max:150',
    ];

    protected array $messages = [
        'mpesa_number.required' => 'M-Pesa number is required.',
        'mpesa_number.regex' => 'M-Pesa number must be in format 07XXXXXXXX.',
        'customer_name.required' => 'Full name is required.',
        'customer_name.max' => 'Full name must not exceed 100 characters.',
        'town.required' => 'Town is required.',
        'town.max' => 'Town must not exceed 100 characters.',
        'description.required' => 'Description is required.',
        'description.max' => 'Description must not exceed 150 characters.',
    ];

    public function boot(PaymentServiceInterface $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function mount()
    {
        $this->loadCart();
    }

    public function loadCart()
    {
        $this->cart = session('cart', []);
        $this->calculateCartTotal();
        $this->cartCount = count($this->cart);
    }

    public function calculateCartTotal(): void
    {
        $this->cartTotal = 0;
        foreach ($this->cart as $item) {
            $this->cartTotal += $item['price'] * $item['quantity'];
        }
    }

    public function updateQuantity($index, $quantity): void
    {
        if ($quantity > 0) {
            $this->cart[$index]['quantity'] = $quantity;
            $this->updateCartSession();
            $this->calculateCartTotal();
        }
    }

    protected function updateCartSession()
    {
        Session::put('cart', $this->cart);
    }

    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart); // Reindex array
        $this->updateCartSession();
        $this->calculateCartTotal();
        $this->cartCount = count($this->cart);

        session()->flash('message', 'Item removed from cart.');
    }

    public function clearCart()
    {
        $this->cart = [];
        $this->cartTotal = 0;
        $this->cartCount = 0;
        Session::forget('cart');

        session()->flash('message', 'Cart cleared.');
    }

    public function updatedMpesaNumber()
    {
        $this->validateOnly('mpesa_number');

        // Format the number as user types
        $this->mpesa_number = preg_replace('/[^0-9]/', '', $this->mpesa_number);
        if (strlen($this->mpesa_number) > 10) {
            $this->mpesa_number = substr($this->mpesa_number, 0, 10);
        }
    }

    public function updatedCustomerName()
    {
        $this->validateOnly('customer_name');
    }

    public function updatedTown()
    {
        $this->validateOnly('town');
    }

    public function updatedDescription()
    {
        $this->validateOnly('description');
    }

    public function submitOrder()
    {
        // Validate all fields
        $this->validate();

        // Check if cart is not empty
        if (empty($this->cart)) {
            session()->flash('error', 'Your cart is empty.');
            return;
        }

        try {
            // Create the order
            $order = $this->createOrder();

            // Save order items
            $this->createOrderItems($order);

            // Send SMS notification
//            $this->sendOrderNotification($order);



            // Initiate payment
            $this->initiatePayment($order);

            // Clear cart
            $this->clearCartSession();

        } catch (\Exception $e) {
            Log::error('Order submission failed', [
                'error' => $e->getMessage(),
                'customer' => $this->customer_name,
                'amount' => $this->cartTotal
            ]);

            session()->flash('error', 'Failed to process your order. Please try again.');
        }
    }

    private function generateTrackingCode()
    {
        $this->showTrackingNumber = true;
        // Option 1: Year + Month + Day + Hour + Minute + Second + Random (e.g., TRK240718143025A1B2)
        $timestamp = now()->format('ymdHis'); // 240718143025
        $random = strtoupper(Str::random(4)); // A1B2
        return $this->tracking_number = $timestamp . $random;
    }

    public function createOrder(): Order
    {
        try {
            $trackingCode = $this->generateTrackingCode();

            $payload = [
                'uuid' => Str::uuid()->toString(),
                'tracking_number' => $trackingCode,
                'customer_name' => $this->customer_name,
                'town' => $this->town,
                'description' => $this->description,
                'mpesa_number' => $this->mpesa_number,
                'mpesa_code' => "324242342",
                'status' => 'pending',
                'payment_status' => 'pending',
                'amount' => $this->cartTotal,
            ];

//            dd($payload);
            $order = Order::create($payload);

            if (!$order) {
                throw new \Exception('Failed to create order');
            }

            $this->dispatch("sent-mpesa-stk-push", ['tracking_number' => $order->tracking_number]);
            return $order;

        } catch (\Exception $e) {
            Log::error('Order creation exception: ' . $e->getMessage());
            throw $e;
        }
    }


    private function createOrderItems(Order $order): void
    {
        $items_data = [];

        foreach ($this->cart as $item) {
            $items_data[] = [
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'size' => $item['size'],
                'color' => $item['color'] ?? null,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        Item::insert($items_data);
    }

    private function sendOrderNotification(Order $order): void
    {
        try {
            $smsService = new SmsService();
            $smsService->to("0700801438");
            $smsService->message(
                "New order #{$order->tracking_number} placed. Amount: KSh " .
                number_format($order->amount, 2) . " from {$order->customer_name}"
            );
            $smsService->send();
        } catch (\Exception $e) {
            \Log::error('SMS notification failed', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function clearCartSession(): void
    {
        $this->cart = [];
        $this->cartTotal = 0;
        $this->cartCount = 0;
        Session::forget('cart');
    }

    private function initiatePayment(Order $order): void
    {
        Log::info('Initiating payment');
        $response = $this->paymentService->initiatePayment(
            phoneNumber: $this->mpesa_number,
//            amount: $order->amount,
            amount: 10,
            reference: $order->tracking_number,
            description: "Payment for Order #{$order->tracking_number}"
        );

        if ($this->paymentService->isPaymentSuccessful($response)) {
            // Store payment reference for tracking
            $order->update([
                'payment_reference' => $response['checkout_request_id'] ?? null,
                'merchant_request_id' => $response['merchant_request_id'] ?? null,
            ]);

            session()->flash('success', 'Order placed successfully! Please complete payment on your phone.');
            session()->flash('trackingNumber', $order->tracking_number);
        } else {
            session()->flash('warning', 'Order placed successfully, but payment initiation failed. Please contact support.');
            session()->flash('trackingNumber', $order->tracking_number);

            Log::warning('Payment initiation failed', [
                'order_id' => $order->id,
                'response' => $response
            ]);
        }

        // Reset form fields
        $this->reset(['mpesa_number', 'customer_name', 'town', 'description', 'use_as_contact']);

        $this->dispatch("sent-mpesa-stk-push", ['tracking_number' => $order->tracking_number]);

    }

    public function formatCurrency($amount): string
    {
        return 'KSh ' . number_format($amount, 2);
    }

    public function render()
    {
        return view('livewire.checkouts.checkout-component', [
            'cart' => $this->cart,
            'cartTotal' => $this->cartTotal,
            'cartCount' => $this->cartCount,
        ]);
    }
}
