<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('create-order', function (User $user, Order $order) {
            return $user->id === $order->user_id;
        });


        Gate::define('access-admin-dashboard', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('access-admin-products', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('access-products', function ($user) {
            return $user->hasPermission('view_reports');
        });
    }
}
