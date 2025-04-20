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
}
