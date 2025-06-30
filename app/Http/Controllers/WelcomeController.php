<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class WelcomeController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')
            ->having('products_count', '>', 0)
            ->get();

        $query = Product::query();

        // If ?category=ID is present, filter products
        if (request()->has('category')) {
            $categoryId = request()->get('category');
            $query->where('category_id', $categoryId);
        }

        $products = $query->get()->map(function ($product) {
            $product->description = \Illuminate\Support\Str::words($product->description, 15, '...');
            return $product;
        });

        return view('welcome', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }


    public function show($slug)
    {
        return view('show', [
            'product' => Product::query()->where('slug', $slug)->firstOrFail()
        ]);
    }


}
