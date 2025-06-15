<?php

namespace App\Http\Controllers;
use App\Classes\AfricasTalkingGatewayException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SmsController
{
    public function sendSms(Request $request): void
    {
        // Validate incoming request
        $validated = $request->validate([
            'cardId' => 'required|string',
            'phoneNumber' => 'required|regex:/^07\d{8}$/'
        ]);

        // Core parameters
        $userId   = 'Pamatech';
        $password = env('SMS_PASSWORD');
        $mobile   = '254' . substr($validated['phoneNumber'], 1); // Convert 07... to 2547...
        $message  = "Card ID {$validated['cardId']} swiped.";
        $senderId = env('SMS_SENDER_ID');

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://smsportal.hostpinnacle.co.ke/SMSApi/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "userid={$userId}&password={$password}&mobile={$mobile}&msg=" . urlencode($message) . "&senderid={$senderId}&msgType=text&duplicatecheck=true&output=json&sendMethod=quick",
            CURLOPT_HTTPHEADER => array(
                "apikey: " . env('SMS_API_KEY'),
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        Log::info("SMS Response: " . $response);

        if ($err) {
            abort(500, "SMS Send Error: $err");
        } else {
            response()->json(json_decode($response), 200)->send();
        }
    }
}
