<?php

namespace App\Services\Payment;

use App\Contracts\PaymentServiceInterface;
use App\ExternalLibraries\FormatPhoneNumberUtil;
use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaPaymentService implements PaymentServiceInterface
{
    private string $consumerKey;
    private string $consumerSecret;
    private string $shortcode;
    private string $passkey;
    private string $baseUrl;
    private string $callbackUrl;

    public function __construct()
    {
        $this->consumerKey = config('services.mpesa.consumer_key', env('MPESA_CONSUMER_KEY'));
        $this->consumerSecret = config('services.mpesa.consumer_secret', env('MPESA_SECRET_KEY'));
        $this->shortcode = config('services.mpesa.shortcode');
        $this->passkey = config('services.mpesa.passkey');
        $this->baseUrl = config('services.mpesa.base_url', 'https://api.safaricom.co.ke');
        $this->callbackUrl = config('services.mpesa.callback_url', url('/api/mpesa/callback'));
    }

    /**
     * Initiate M-Pesa STK Push payment
     */
    public function initiatePayment(string $phoneNumber, float $amount, string $reference, string $description = ''): array
    {
        try {
            $accessToken = $this->getAccessToken();

            if (!$accessToken) {
                return [
                    'success' => false,
                    'message' => 'Failed to authenticate with M-Pesa API',
                    'response_code' => '1'
                ];
            }

            $formattedPhone = $this->formatPhoneNumber($phoneNumber);
            $timestamp = now()->format('YmdHis');
            $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

            $payload = [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => (int)$amount,
                'PartyA' => $formattedPhone,
                'PartyB' => $this->shortcode,
                'PhoneNumber' => $formattedPhone,
                'CallBackURL' => $this->callbackUrl,
                'AccountReference' => $reference,
                'TransactionDesc' => $description ?: "Payment for Order #{$reference}",
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', $payload);

            $responseData = $response->json();

            if ($response->successful() && isset($responseData['ResponseCode']) && $responseData['ResponseCode'] === '0') {
                return [
                    'success' => true,
                    'message' => 'Payment initiated successfully',
                    'response_code' => $responseData['ResponseCode'],
                    'checkout_request_id' => $responseData['CheckoutRequestID'] ?? null,
                    'merchant_request_id' => $responseData['MerchantRequestID'] ?? null,
                    'response_description' => $responseData['ResponseDescription'] ?? '',
                ];
            }

            return [
                'success' => false,
                'message' => $responseData['ResponseDescription'] ?? 'Payment initiation failed',
                'response_code' => $responseData['ResponseCode'] ?? '1',
                'error_code' => $responseData['errorCode'] ?? null,
            ];

        } catch (Exception $e) {
            Log::error('M-Pesa payment initiation failed', [
                'phone' => $phoneNumber,
                'amount' => $amount,
                'reference' => $reference,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Payment service temporarily unavailable',
                'response_code' => '1'
            ];
        }
    }

    /**
     * Get M-Pesa API access token
     */
    public function getAccessToken(): ?string
    {
        try {
            $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $credentials,
            ])->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');

            if ($response->successful()) {
                $data = $response->json();
                return $data['access_token'] ?? null;
            }

            Log::error('Failed to get M-Pesa access token', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;

        } catch (Exception $e) {
            Log::error('M-Pesa access token request failed', [
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Format phone number to M-Pesa required format
     */
    public function formatPhoneNumber(string $phoneNumber): string
    {
        $phoneFormat = new FormatPhoneNumberUtil();
        $formattedPhone = $phoneFormat::formatPhoneNumber($phoneNumber);

        // Convert 07XXXXXXXX to 2547XXXXXXXX
        if (str_starts_with($formattedPhone, '07')) {
            $formattedPhone = '254' . substr($formattedPhone, 1);
        }

        return $formattedPhone;
    }

    /**
     * Check the status of a payment transaction
     */
    public function checkPaymentStatus(string $transactionId): array
    {
        try {
            $accessToken = $this->getAccessToken();

            if (!$accessToken) {
                return [
                    'success' => false,
                    'message' => 'Failed to authenticate with M-Pesa API'
                ];
            }

            $timestamp = now()->format('YmdHis');
            $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

            $payload = [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'CheckoutRequestID' => $transactionId,
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/mpesa/stkpushquery/v1/query', $payload);

            return $response->json();

        } catch (Exception $e) {
            Log::error('M-Pesa payment status check failed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Unable to check payment status'
            ];
        }
    }

    /**
     * Check if payment response indicates success
     */
    public function isPaymentSuccessful(array $response): bool
    {
        return isset($response['success']) && $response['success'] === true;
    }
}
