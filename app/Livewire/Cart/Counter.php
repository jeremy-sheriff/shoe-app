<?php

namespace App\Livewire\Cart;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Counter extends Component
{
    public int $totalItems = 0;

    public $cart = [];


    protected $listeners = [
        'cart-updated' => 'updateCart'
    ];

    public function mount()
    {
        $this->updateCart();
    }

    function updateCart()
    {
        $this->cart = Session::get('cart', []);
        $this->totalItems = count($this->cart);
    }

    public function render()
    {
        return view('livewire.cart.counter');
    }
}
