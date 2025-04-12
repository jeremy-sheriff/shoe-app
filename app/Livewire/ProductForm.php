<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductForm extends Component
{
    public $showModal = false;

    public $name, $description, $price, $stock, $sku, $is_active = true, $status = 'active';

    protected $rules = [
        'name'        => 'required|string|max:255',
        'description' => 'nullable|string',
        'price'       => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:0',
        'sku'         => 'required|string|unique:products,sku',
        'status'      => 'required|in:draft,active,archived',
        'is_active'   => 'boolean',
    ];

    public function create()
    {
        $this->reset(['name', 'description', 'price', 'stock', 'sku', 'status', 'is_active']);
        $this->sku = strtoupper(Str::random(8));
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        Product::create([
            'name'        => $this->name,
            'description' => $this->description,
            'price'       => $this->price,
            'stock'       => $this->stock,
            'sku'         => $this->sku,
            'status'      => $this->status,
            'is_active'   => $this->is_active,
        ]);

        $this->showModal = false;
        session()->flash('success', 'Product created successfully!');
        $this->reset();
        $this->emit('productCreated');
    }

    public function render()
    {
        return view('livewire.product-form');
    }
}
