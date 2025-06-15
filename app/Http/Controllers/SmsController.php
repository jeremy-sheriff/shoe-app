<?php

namespace App\Http\Controllers;

use App\Classes\AfricasTalkingGateway;
use App\Classes\AfricasTalkingGatewayException;
use Illuminate\Support\Facades\Log;

class SmsController
{

    /**
     * @throws AfricasTalkingGatewayException
     */
    public function sendSms(): void
    {
        // Core parameters
        $userId   = 'Pamatech';
        $password = env('SMS_PASSWORD');
        $mobile   = '254712419949';
        $message  = 'Hello World! This is a test message!';
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

        Log::info($response);

        if ($err) {
            echo "cURL Error #: " . $err;
        } else {
            echo $response;
        }
    }



    public function sendSMS2(): void{
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://smsportal.hostpinnacle.co.ke/SMSApi/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "userid=Pamatech&password=ebuc7hZr&mobile=254712419949&msg=Hello+World%21+This+is+a+test+message%21&senderid=Pamatech&msgType=text&duplicatecheck=true&output=json&sendMethod=quick",
            CURLOPT_HTTPHEADER => array(
                "apikey: ". env('SMS_API_KEY'),
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);

        Log::info($response);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

    }

}
