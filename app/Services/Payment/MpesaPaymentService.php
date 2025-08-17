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

        // Log initialization
        Log::info('M-Pesa service initialized', [
            'shortcode' => $this->shortcode,
            'base_url' => $this->baseUrl,
            'callback_url' => $this->callbackUrl,
            'consumer_key_present' => !empty($this->consumerKey),
            'consumer_secret_present' => !empty($this->consumerSecret),
            'passkey_present' => !empty($this->passkey)
        ]);
    }

    /**
     * Initiate M-Pesa STK Push payment
     */
    public function initiatePayment(string $phoneNumber, float $amount, string $reference, string $description = ''): array
    {
        Log::info('Starting M-Pesa payment initiation', [
            'phone_number' => $phoneNumber,
            'amount' => $amount,
            'reference' => $reference,
            'description' => $description
        ]);

        try {
            Log::info('Attempting to get M-Pesa access token');
            $accessToken = $this->getAccessToken();

            if (!$accessToken) {
                Log::error('Failed to obtain M-Pesa access token');
                return [
                    'success' => false,
                    'message' => 'Failed to authenticate with M-Pesa API',
                    'response_code' => '1'
                ];
            }

            Log::info('Access token obtained successfully');

            $formattedPhone = $this->formatPhoneNumber($phoneNumber);
            Log::info('Phone number formatted', [
                'original' => $phoneNumber,
                'formatted' => $formattedPhone
            ]);

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

            Log::info('M-Pesa STK Push payload prepared', [
                'payload' => array_merge($payload, ['Password' => '[REDACTED]']), // Hide password in logs
                'endpoint' => $this->baseUrl . '/mpesa/stkpush/v1/processrequest'
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', $payload);

            $responseData = $response->json();

            Log::info('M-Pesa STK Push response received', [
                'status_code' => $response->status(),
                'response_data' => $responseData,
                'response_headers' => $response->headers()
            ]);

            if ($response->successful() && isset($responseData['ResponseCode']) && $responseData['ResponseCode'] === '0') {
                Log::info('M-Pesa payment initiated successfully', [
                    'checkout_request_id' => $responseData['CheckoutRequestID'] ?? null,
                    'merchant_request_id' => $responseData['MerchantRequestID'] ?? null,
                    'response_description' => $responseData['ResponseDescription'] ?? ''
                ]);

                return [
                    'success' => true,
                    'message' => 'Payment initiated successfully',
                    'response_code' => $responseData['ResponseCode'],
                    'checkout_request_id' => $responseData['CheckoutRequestID'] ?? null,
                    'merchant_request_id' => $responseData['MerchantRequestID'] ?? null,
                    'response_description' => $responseData['ResponseDescription'] ?? '',
                ];
            }

            Log::warning('M-Pesa payment initiation failed', [
                'response_code' => $responseData['ResponseCode'] ?? 'unknown',
                'response_description' => $responseData['ResponseDescription'] ?? 'No description provided',
                'error_code' => $responseData['errorCode'] ?? null,
                'full_response' => $responseData
            ]);

            return [
                'success' => false,
                'message' => $responseData['ResponseDescription'] ?? 'Payment initiation failed',
                'response_code' => $responseData['ResponseCode'] ?? '1',
                'error_code' => $responseData['errorCode'] ?? null,
            ];

        } catch (Exception $e) {
            Log::error('M-Pesa payment initiation exception occurred', [
                'phone' => $phoneNumber,
                'amount' => $amount,
                'reference' => $reference,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
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
        Log::info('Requesting M-Pesa access token', [
            'endpoint' => $this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials',
            'consumer_key_length' => strlen($this->consumerKey),
            'consumer_secret_length' => strlen($this->consumerSecret)
        ]);

        try {
            $credentials = base64_encode($this->consumerKey . ':' . $this->consumerSecret);

            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $credentials,
            ])->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');

            Log::info('M-Pesa access token response received', [
                'status_code' => $response->status(),
                'response_headers' => $response->headers(),
                'response_body_length' => strlen($response->body())
            ]);

            if ($response->successful()) {
                $data = $response->json();

                Log::info('M-Pesa access token obtained successfully', [
                    'token_length' => isset($data['access_token']) ? strlen($data['access_token']) : 0,
                    'expires_in' => $data['expires_in'] ?? null
                ]);

                return $data['access_token'] ?? null;
            }

            Log::error('Failed to get M-Pesa access token', [
                'status' => $response->status(),
                'response_body' => $response->body(),
                'response_json' => $response->json()
            ]);

            return null;

        } catch (Exception $e) {
            Log::error('M-Pesa access token request exception', [
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);

            return null;
        }
    }

    /**
     * Format phone number to M-Pesa required format
     */
    public function formatPhoneNumber(string $phoneNumber): string
    {
        Log::info('Formatting phone number', ['original' => $phoneNumber]);

        $phoneFormat = new FormatPhoneNumberUtil();
        $formattedPhone = $phoneFormat::formatPhoneNumber($phoneNumber);

        Log::info('Phone number after initial formatting', ['formatted' => $formattedPhone]);

        // Convert 07XXXXXXXX to 2547XXXXXXXX
        if (str_starts_with($formattedPhone, '07')) {
            $formattedPhone = '254' . substr($formattedPhone, 1);
            Log::info('Phone number converted from 07 format to 254 format', ['final_formatted' => $formattedPhone]);
        }

        return $formattedPhone;
    }

    /**
     * Check the status of a payment transaction
     */
    public function checkPaymentStatus(string $transactionId): array
    {
        Log::info('Checking M-Pesa payment status', ['transaction_id' => $transactionId]);

        try {
            $accessToken = $this->getAccessToken();

            if (!$accessToken) {
                Log::error('Failed to get access token for payment status check');
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

            Log::info('M-Pesa payment status query payload', [
                'payload' => array_merge($payload, ['Password' => '[REDACTED]']),
                'endpoint' => $this->baseUrl . '/mpesa/stkpushquery/v1/query'
            ]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/mpesa/stkpushquery/v1/query', $payload);

            $responseData = $response->json();

            Log::info('M-Pesa payment status response received', [
                'status_code' => $response->status(),
                'response_data' => $responseData
            ]);

            return $responseData;

        } catch (Exception $e) {
            Log::error('M-Pesa payment status check exception', [
                'transaction_id' => $transactionId,
                'error_message' => $e->getMessage(),
                'error_trace' => $e->getTraceAsString(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
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
        $isSuccessful = isset($response['success']) && $response['success'] === true;

        Log::info('Checking if payment is successful', [
            'response' => $response,
            'is_successful' => $isSuccessful
        ]);

        return $isSuccessful;
    }
}
