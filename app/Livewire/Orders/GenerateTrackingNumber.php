<?php

namespace App\Livewire\Orders;

use Illuminate\Support\Str;
use Livewire\Component;

class GenerateTrackingNumber extends Component
{
    public string $tracking_number = '';
    protected $listeners = [
        'sent-mpesa-stk-push' => 'generateTrackingNumber'
    ];

    public function render()
    {
        return view('livewire.orders.generate-tracking-number');
    }

    public function generateTrackingNumber(): void
    {
        // Option 1: Year + Month + Day + Hour + Minute + Second + Random (e.g., TRK240718143025A1B2)
        $timestamp = now()->format('ymdHis'); // 240718143025
        $random = strtoupper(Str::random(4)); // A1B2
        $this->tracking_number = $timestamp . $random;
    }
}
