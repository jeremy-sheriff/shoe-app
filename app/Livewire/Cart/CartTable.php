<?php

namespace App\Livewire\Cart;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CartTable extends Component
{
    public array $cart = [];
    public int $cartTotal = 0;

    protected $listeners = [
        'cart-updated' => 'updateCart',
        'action-happened' => 'handleAction',
        'sent-mpesa-stk-push' => "clearCart"
    ];

    public function mount()
    {
        $this->updateCart();
    }

    public function clearCart()
    {
        Session::forget('cart');
        $this->cart = [];
        $this->cartTotal = 0;
        $this->dispatch('cart-updated');
    }

    public function updateCart()
    {
        $this->cart = Session::get('cart', []);
        $this->calculateTotal();
    }

    public function calculateTotal()
    {
        $this->cartTotal = 0;
        foreach ($this->cart as $item) {
            $this->cartTotal += $item['price'] * $item['quantity'];
        }
    }

    public function handleAction()
    {
        Log::info("Action happened");
    }

    public function increaseQuantity($cartKey)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
            Session::put('cart', $cart);
            $this->updateCart();
            $this->dispatch('cart-updated');
        }
    }

    public function decreaseQuantity($cartKey)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$cartKey])) {
            if ($cart[$cartKey]['quantity'] > 1) {
                $cart[$cartKey]['quantity']--;
            } else {
                unset($cart[$cartKey]);
            }
            Session::put('cart', $cart);
            $this->updateCart();
            $this->dispatch('cart-updated');
        }
    }

    public function removeItem($cartKey)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
            Session::put('cart', $cart);
            $this->updateCart();
            $this->dispatch('cart-updated');
        }
    }

    public function render()
    {
        return view('livewire.cart.cart-table');
    }
}
