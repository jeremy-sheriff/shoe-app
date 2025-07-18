<?php

namespace App\Livewire\Cart;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CartComponent extends Component
{
    public $cart = [];
    public $cartTotal = 0;

    protected $listeners = ['cart-updated' => 'updateCart'];

    public function mount()
    {
        $this->updateCart();
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
        return view('livewire.cart.cart-component', ['cart' => $this->cart, 'cartTotal' => $this->cartTotal]);;
    }
}
