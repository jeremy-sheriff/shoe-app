<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(){
        return view('livewire.orders.index', [
            'orders' => Order::query()->latest()->paginate(10),
        ]);
    }


    public function customerOrders(){
        return view('livewire.orders.customer-orders', [
            'orders' => Order::query()->latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $imagePath = null;

        if ($request->hasFile('sample_image')) {
            $imagePath = $request->file('sample_image')->store('orders-samples', 'public');
        }

        $validated = $request->validate([
            'shoe_name' => 'required|string|max:255',
            'size' => 'required|integer|min:1|max:50',
            'color' => 'required|string|max:50',
            'quantity' => 'required|integer|min:1',
            'description' => 'required|string',
            'sample_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        Order::create([
            'uuid' => Str::uuid(),
            'user_id' => auth()->id(),
            'shoe_name' => $validated['shoe_name'],
            'size' => $validated['size'],
            'color' => $validated['color'],
            'quantity' => $validated['quantity'],
            'description' => $validated['description'],
            'image_path' => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Your order has been placed!');
    }






    public function create(){

    }
}
