<?php

declare(strict_types=1);

namespace App\Providers;

use App\Payments\PaymentManager;
use Illuminate\Support\ServiceProvider;
use Stripe\StripeClient;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
class PaymentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/payment.php', 'payment');


        $this->app->singleton(PayPalClient::class, fn () => new PayPalClient);

        $this->app->singleton(StripeClient::class, fn () => new StripeClient([
            'api_key' => config('services.stripe.secret'),
        ]));


        /*foreach (config('payment.gateways') as $driver => $concrete) {
            $this->app->singleton($concrete, fn ($app) => $app->make($concrete));
        }*/

        // — Manager/Fascade —
        $this->app->singleton(PaymentManager::class);
        $this->app->alias(PaymentManager::class, 'payment');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/payment.php' => config_path('payment.php'),
        ], 'payment-config');
    }
}
