<?php

namespace App\Contracts;

interface PaymentServiceInterface
{
    /**
     * Initiate a payment request
     *
     * @param string $phoneNumber
     * @param float $amount
     * @param string $reference
     * @param string $description
     * @return array
     */
    public function initiatePayment(string $phoneNumber, float $amount, string $reference, string $description = ''): array;

    /**
     * Check payment status
     *
     * @param string $transactionId
     * @return array
     */
    public function checkPaymentStatus(string $transactionId): array;

    /**
     * Get access token for API authentication
     *
     * @return string|null
     */
    public function getAccessToken(): ?string;

    /**
     * Format phone number to required format
     *
     * @param string $phoneNumber
     * @return string
     */
    public function formatPhoneNumber(string $phoneNumber): string;

    /**
     * Validate payment response
     *
     * @param array $response
     * @return bool
     */
    public function isPaymentSuccessful(array $response): bool;
}
