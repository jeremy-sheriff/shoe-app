<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function confirm(Request $request)
    {
        $request->validate([
            'mpesa_number' => 'required|regex:/^07\d{8}$/',
            'county' => 'required|string|max:100',
            'town' => 'required|string|max:100',
            'pickup_point' => 'required|string|max:150',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        // Example: log data (replace this with DB save or order logic)
        logger()->info('Order Placed', [
            'mpesa_number' => $request->mpesa_number,
            'address' => [
                'county' => $request->county,
                'town' => $request->town,
                'pickup_point' => $request->pickup_point,
            ],
            'cart_items' => $cart,
        ]);

        // TODO: You can save to `orders` table or trigger M-Pesa STK here

        // Clear cart
        Session::forget('cart');

        return redirect()->back()->with('success', 'Your order has been placed. We will contact you shortly!');
    }
}

