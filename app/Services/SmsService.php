<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class SmsService
{
    protected string $userId;
    protected string $password;
    protected string $mobile;
    protected string $message;
    protected string $senderId;

    public function __construct()
    {
        $this->userId = 'Pamatech';
        $this->password = env('SMS_PASSWORD');
        $this->senderId = env('SMS_SENDER_ID');
    }

    public function to(string $mobile): self
    {
        $this->mobile = '254' . substr($mobile, 1);
        return $this;
    }

    public function message(string $text): self
    {
        $this->message = $text;
        return $this;
    }

    public function send(): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://smsportal.hostpinnacle.co.ke/SMSApi/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => http_build_query([
                'userid'        => $this->userId,
                'password'      => $this->password,
                'mobile'        => $this->mobile,
                'msg'           => $this->message,
                'senderid'      => $this->senderId,
                'msgType'       => 'text',
                'duplicatecheck'=> 'true',
                'output'        => 'json',
                'sendMethod'    => 'quick',
            ]),
            CURLOPT_HTTPHEADER => [
                "apikey: " . env('SMS_API_KEY'),
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded"
            ],
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        Log::info("SMS Response: " . $response);

        if ($error) {
            throw new \Exception("SMS Send Error: $error");
        }

        return json_decode($response, true);
    }
}
