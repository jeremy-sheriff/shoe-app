<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SmsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/checkout', [CheckoutController::class, 'stkPush'])->name('checkout.stk-push');
Route::post('/sms/send', [SmsController::class, 'sendSms'])->name('sms.send');
