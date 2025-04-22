<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;

class WelcomeController extends Controller
{
    public function index()
    {
        $products = Product::all()->map(function ($product) {
            $product->description = Str::words($product->description, 15, '...');
            return $product;
        });

        return view('welcome', [
            'products' => $products,
        ]);
    }

    public function show($slug)
    {
        return view('show', [
            'product' => Product::query()->where('slug', $slug)->firstOrFail()
        ]);
    }


}
