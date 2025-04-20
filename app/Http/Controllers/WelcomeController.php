<?php

namespace App\Http\Controllers;

use App\Models\Product;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome', [
            'products' => Product::all(),
        ]);
    }

    public function show($id)
    {
        return view('show', [
            'product' => Product::query()->findOrFail($id),
        ]);
    }


}
