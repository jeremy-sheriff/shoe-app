<?php

namespace App\Livewire\Cart;

use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AddToCart extends Component
{


    public $product;
    public $quantity = 1;
    public $selectedColor = '';
    public $selectedSize = '';
    public $showSuccess = false;

    protected $rules = [
        'quantity' => 'required|integer|min:1',
        'selectedSize' => 'required',
    ];

    protected $messages = [
        'selectedSize.required' => 'Please select a size.',
        'quantity.min' => 'Quantity must be at least 1.',
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function addToCart()
    {
        $this->validate();

        $cart = Session::get('cart', []);

        // Create unique key for cart item (product + color + size)
        $cartKey = $this->product->id . '_' . $this->selectedColor . '_' . $this->selectedSize;

        // Get first image for display
        $firstImage = $this->product->images->first();

        if (isset($cart[$cartKey])) {
            // If item already exists, update quantity
            $cart[$cartKey]['quantity'] += $this->quantity;
        } else {
            // Add new item to cart
            $cart[$cartKey] = [
                'name' => $this->product->name,
                'price' => $this->product->price,
                'quantity' => $this->quantity,
                'color' => $this->selectedColor,
                'size' => $this->selectedSize,
                'image' => $firstImage ? $firstImage->path : null,
                'product_id' => $this->product->id,
            ];
        }

        Session::put('cart', $cart);

        // Show success message
        $this->showSuccess = true;

        // Emit event to update cart count/display
        $this->dispatch('cart-updated');

        // Hide success message after 3 seconds
        $this->dispatch('hide-success');

        $this->dispatch('action-happened', ['data' => 'some value']);
    }

    public function hideSuccess(): void
    {
        $this->showSuccess = false;
    }


    public function render()
    {
        return view('livewire.cart.add-to-cart');
    }
}
