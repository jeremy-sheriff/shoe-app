<?php

namespace App\Livewire\Orders;

use Livewire\Component;

class GenerateTrackingNumber extends Component
{

    public bool $showTrackingNumber = false;

    public string $tracking_number = '';
    protected $listeners = [
        'sent-mpesa-stk-push' => 'displayTrackingNumber'
    ];

    public function render()
    {
        return view('livewire.orders.generate-tracking-number');
    }

    public function displayTrackingNumber($data): void
    {
        $this->tracking_number = $data['tracking_number'] ?? '';
        $this->showTrackingNumber = true;
    }
}
