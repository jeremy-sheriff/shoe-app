<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Tracking extends Component
{
    public string $tracking_number = '';
    public $order = null;
    public array $errors = [];

    protected array $rules = [
        'tracking_number' => 'required|string|min:3'
    ];

    protected array $messages = [
        'tracking_number.required' => 'Please enter a tracking number',
        'tracking_number.min' => 'Tracking number must be at least 3 characters long'
    ];

    public function trackOrder(): void
    {

        Log::info("tracking number: $this->tracking_number");
        $this->errors = [];

        // Validate the input
        $validator = Validator::make(['tracking_number' => $this->tracking_number], $this->rules, $this->messages);

        if ($validator->fails()) {
            $this->errors = $validator->errors()->all();
            return;
        }

        // Find the order by tracking number
        $order = Order::query()->where('tracking_number', $this->tracking_number)->first();

        if (!$order) {
            $this->errors = ['Order not found. Please check your tracking number and try again.'];
            return;
        }


        // Set the order data
        $this->order = [
            'tracking_number' => $order->tracking_number,
            'customer_name' => $order->customer_name,
            'town' => $order->town,
            'mpesa_number' => $order->mpesa_number,
            'amount' => $order->amount,
            'payment_status' => $order->payment_status,
            'status' => $order->status,
            'created_at' => $order->created_at,
        ];
    }


    public function render()
    {
        return view('livewire.orders.tracking');
    }
}
