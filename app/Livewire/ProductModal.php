<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductModal extends Component
{
    public $showModal = false;
    public $name, $description, $price, $stock, $sku, $is_active = true, $status = 'active';

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'sku' => 'required|string|unique:products,sku',
        'status' => 'required|in:draft,active,archived',
        'is_active' => 'boolean',
    ];

    public function create(): void
    {
        $this->resetExcept('showModal');
        $this->sku = strtoupper(Str::random(8));
        $this->showModal = true;
    }

    public function save(): void
    {
        $this->validate();

        Product::query()->create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock' => $this->stock,
            'sku' => $this->sku,
            'status' => $this->status,
            'is_active' => $this->is_active,
        ]);

        $this->dispatch('productCreated');
        // emit event to refresh table
        $this->reset();
        $this->showModal = false;
        session()->flash('success', 'Product created successfully!');
    }

    public function render()
    {
        return view('livewire.product-modal');
    }
}

