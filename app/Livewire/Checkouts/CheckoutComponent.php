<?php

namespace App\Livewire\Checkouts;

use App\ExternalLibraries\FormatPhoneNumberUtil;
use App\Models\Item;
use App\Models\Order;
use App\Services\SmsService;
use Carbon\Carbon;
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
        'mpesa_number.required' => 'M-Pesa number is xrequired.',
        'mpesa_number.regex' => 'M-Pesa number must be in format 07XXXXXXXX.',
        'customer_name.required' => 'Full name is required.',
        'customer_name.max' => 'Full name must not exceed 100 characters.',
        'town.required' => 'Town is required.',
        'town.max' => 'Town must not exceed 100 characters.',
        'description.required' => 'Description is required.',
        'description.max' => 'Description must not exceed 150 characters.',
    ];

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

        // Process the order directly in Livewire
        $trackingCode = strtoupper(Str::random(10));
        $cartTotal = $this->cartTotal;
        $cartItems = [];


        foreach ($this->cart as $item) {
            $cartItems[] = [
                'product_id' => $item['product_id'],
                'size' => $item['size'],
                'color' => $item['color'] ?? null,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ];
        }

        // Create the order
        $order = Order::query()->create([
            'uuid' => Str::uuid(),
            'tracking_number' => $trackingCode,
            'customer_name' => $this->customer_name,
            'town' => $this->town,
            'description' => $this->description,
            'mpesa_number' => $this->mpesa_number,
            'status' => 'pending',
            'payment_status' => 'pending',
            'amount' => $cartTotal,
        ]);

        // Save order items
        $items_data = [];
        foreach ($cartItems as $item) {
            $items_data[] = [
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'size' => $item['size'],
                'color' => $item['color'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        Item::query()->insert($items_data);

        // Send SMS notification
        try {
            $smsService = new SmsService();
            $smsService->to("0700801438");
            $smsService->message("New order #{$trackingCode} placed. Amount: KSh " . number_format($cartTotal, 2) . " from {$this->customer_name}");
            $smsService->send();
        } catch (\Exception $e) {
            // Log SMS error but don't fail the order
//            Log::error('SMS notification failed: ' . $e->getMessage());
        }

        // Clear cart
        $this->cart = [];
        $this->cartTotal = 0;
        $this->cartCount = 0;
        Session::forget('cart');

        // Initiate STK Push
        $response = $this->initiateStkPush($this->mpesa_number, $cartTotal, $trackingCode);

        if (isset($response['ResponseCode']) && $response['ResponseCode'] == '0') {
            session()->flash('success', 'Order placed successfully! Please complete payment on your phone.');
            session()->flash('trackingNumber', $trackingCode);
        } else {
            session()->flash('warning', 'Order placed successfully, but payment initiation failed. Please contact support.');
            session()->flash('trackingNumber', $trackingCode);
        }

        // Redirect to success page
//        return redirect()->route('order.success');
    }

    private function initiateStkPush($mpesa_number, $amount, $order_id)
    {
        $phoneFormat = new FormatPhoneNumberUtil();
        $phone_paying = $phoneFormat::formatPhoneNumber($mpesa_number);

        if ($this->startsWith($phone_paying, "07")) {
            $phone_paying = str_replace("07", "2547", $phone_paying);
        }

        $merchant_id = env('MPESA_SHORTCODE');
        $passkey = env('MPESA_PASSKEY');
        $timestamp = date("YmdHis");
        $password = base64_encode($merchant_id . $passkey . $timestamp);
        $access_token = $this->getAccessToken();

        if (!$access_token) {
            return ['ResponseCode' => '1', 'ResponseDescription' => 'Failed to get access token'];
        }

        $payload = [
            'BusinessShortCode' => $merchant_id,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone_paying,
            'PartyB' => $merchant_id,
            'PhoneNumber' => $phone_paying,
            'CallBackURL' => url('/api/mpesa/callback'),
            'AccountReference' => $order_id,
            'TransactionDesc' => 'Payment for Order #' . $order_id,
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:Bearer ' . $access_token
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($curl);

        if (curl_error($curl)) {
            \Log::error('CURL Error: ' . curl_error($curl));
            curl_close($curl);
            return ['ResponseCode' => '1', 'ResponseDescription' => 'Network error'];
        }

        curl_close($curl);

        return json_decode($response, true);
    }

    private function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    private function getAccessToken()
    {
        $consumer_key = env('MPESA_CONSUMER_KEY');
        $consumer_secret = env('MPESA_SECRET_KEY');

        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode($consumer_key . ":" . $consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($curl);
        $access_token = json_decode($curl_response);

        curl_close($curl);

        return $access_token->access_token ?? null;
    }

    public function formatCurrency($amount)
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
