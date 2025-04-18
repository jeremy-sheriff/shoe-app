<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('home', 'home')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/orders', [OrderController::class, 'customerOrders'])->name('orders.index.users')->middleware(['auth']);
    Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store')->middleware(['auth']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('orders.index')->middleware(['auth', 'can:access-admin-dashboard']);
    Route::get('/admin/orders/create', [OrderController::class, 'create'])->name('orders.create');

    Route::get('/products', [ProductController::class, 'index'])->name('products.index')->middleware(['auth', 'can:access-admin-products']);
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
