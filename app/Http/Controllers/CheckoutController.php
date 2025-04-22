<?php

namespace App\Http\Controllers;

use App\ExternalLibraries\FormatPhoneNumberUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    public function confirm(Request $request)
    {
        $request->validate([
            'mpesa_number' => 'required|regex:/^07\d{8}$/',
            'customer_name' => 'required|string|max:100',
            'town' => 'required|string|max:100',
            'description' => 'required|string|max:150',
        ]);

        $cart = session('cart', []);
        $cartTotal = 0;

        foreach ($cart as $item) {
            $cartTotal += $item['price'] * $item['quantity'];
        }

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
        $response = $this->initiateStkPush($request->mpesa_number, $cartTotal, uniqid());

        if (isset($response['ResponseCode']) && $response['ResponseCode'] == '0') {
            return redirect()->back()->with('success', 'Order placed! Please complete payment on your phone.');
        } else {
            return redirect()->back()->with('error', 'Failed to initiate M-Pesa STK Push. Please try again.');
        }

    }

    public function getAccessToken()
    {
        //Variables specific to this application
        $consumer_key = env('MPESA_CONSUMER_KEY'); //Get these two from DARAJA Platform
        $consumer_secret = env('MPESA_SECTRT_KEY');

        //START CURL
        $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        $credentials = base64_encode($consumer_key . ":" . $consumer_secret);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $credentials));
        curl_setopt($curl, CURLOPT_HEADER, 0);//Make it not return headers...true retirns header
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//MAGIC..

        $curl_response = curl_exec($curl);
        $access_token = json_decode($curl_response);
        return $access_token->access_token;
    }

    private function initiateStkPush($mpesa_number, $amount, $order_id)
    {
        $phoneFormat = new FormatPhoneNumberUtil();
        $phone_paying = $phoneFormat::formatPhoneNumber($mpesa_number);

        if ($this->startsWith($phone_paying, "07")) {
            $phone_paying = str_replace("07", "2547", $phone_paying);
        }

        $merchant_id = env('MPESA_SHORTCODE');
        $passkey = env('MPESA_PASSKEY');
        $timestamp = date("YmdHis");
        $password = base64_encode($merchant_id . $passkey . $timestamp);
        $access_token = $this->getAccessToken();

        $payload = [
            'BusinessShortCode' => $merchant_id,
            'Password' => $password,
            'Timestamp' => $timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $amount,
            'PartyA' => $phone_paying,
            'PartyB' => $merchant_id,
            'PhoneNumber' => $phone_paying,
            'CallBackURL' => "https://yourdomain.com/api/callback", // Update accordingly
            'AccountReference' => 'Order_' . $order_id,
            'TransactionDesc' => 'Payment for Order #' . $order_id,
        ];

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest');
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type:application/json',
            'Authorization:Bearer ' . $access_token
        ]);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));

        $response = curl_exec($curl);
        curl_close($curl);

        Log::info($response);

        return json_decode($response, true);
    }


    function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

}

