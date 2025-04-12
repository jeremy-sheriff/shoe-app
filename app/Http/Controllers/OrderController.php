<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(){
        return view('livewire.orders.index', [
            'orders' => Order::query()->latest()->paginate(10),
        ]);
    }




    public function create(){

    }
}
