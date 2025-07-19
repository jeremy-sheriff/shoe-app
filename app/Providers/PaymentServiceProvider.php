<?php

namespace App\Providers;

use App\Contracts\PaymentServiceInterface;
use App\Services\Payment\MpesaPaymentService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentServiceInterface::class, MpesaPaymentService::class);
    }


    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
