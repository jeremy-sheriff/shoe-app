<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    function index(){
      return view('livewire.products.index', [
            'products' => Product::query()->latest()->paginate(10),
        ]);

    }



    function create()
    {
        return view('livewire.product-form');
    }
}
