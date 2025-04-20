<?php

namespace App\Http\Controllers;

use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalOrders' => Order::query()->count(),
            'processingOrders' => Order::query()->where('status', 'processing')->count(),
            'completedOrders' => Order::query()->where('status', 'completed')->count(),
            'cancelledOrders' => Order::query()->where('status', 'cancelled')->count(),
        ]);
    }
}
