<?php

return [
    'default' => env('PAYMENT_DRIVER', 'paypal'),

    'gateways' => [
        'stripe' => App\Payments\Providers\StripeGateway::class,
        'paypal' => App\Payments\Providers\PayPalGateway::class,
        'paystack' => App\Payments\Providers\PayStackGateway::class,
        //'orange_money' => App\Payments\Providers\OrangeMoneyGateway::class,
    ],

    'stripe' => [
        'api_keys'=>[
            'secret' => env('STRIPE_SECRET'),
            'key' => env('STRIPE_KEY'),
            'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'), // si tu veux gérer les webhooks,
        ],
        'config' => [
            'currencies' => ['USD', 'EUR', 'GBP'],
            'locales' => ['en', 'fr', 'es'],
            'fallback_currency' => 'usd',
        ]
    ],

    'paypal' => [
        'api_keys'=>[
            'mode' => env('PAYPAL_MODE', 'sandbox'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
                'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
                'app_id' => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id' => env('PAYPAL_LIVE_CLIENT_ID', ''),
                'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
                'app_id' => env('PAYPAL_LIVE_APP_ID', ''),
            ],
            'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can only be 'Sale', 'Authorization' or 'Order'
            'currency' => env('PAYPAL_CURRENCY', 'USD'),
            'notify_url' => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale' => env('PAYPAL_LOCALE', 'en_US'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl' => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.,
        ],
        'config'=>[
            'currencies' => ['AUD', 'BRL', 'CAD', 'CZK', 'DKK', 'EUR', 'HKD', 'HUF', 'ILS', 'INR', 'JPY', 'MYR', 'MXN', 'NOK', 'NZD', 'PHP', 'PLN', 'GBP', 'SGD', 'SEK', 'CHF', 'TWD', 'THB', 'USD', 'RUB', 'CNY'],
            'locales' => ['en_US', 'fr_FR'],
            'fallback_currency' => 'usd',
        ]

    ],

    'paystack' => [
        'api_keys'=>[
            'secret'=>env('PAYSTACK_SECRET_KEY'),
            'public_key'=>env('PAYSTACK_PUBLIC_KEY'),
            'webhook_secret'=>env('PAYSTACK_WEBHOOK_KEY')
        ],
        'config' => [
            'currencies' => ['NGN', 'USD', 'GHS', 'ZAR'],
            'locales' => ['en', 'fr'],
            'fallback_currency' => 'NGN',
            'payment_email'=>'contact@app.com'
        ]

    ],
    'orange_money' => [
        'api_keys'=>[

        ],
        'config'=>[
            'currencies' => ['XAF', 'XOF'],
            'locales' => ['fr'],
            'fallback_currency' => 'XAF',
        ]
    ],
    // taux de conversion pour fallback
    'conversion_rates' => [
        'EUR' => [
            'USD' => 1.12,
            'NGN' => 1783,
        ],
        'USD' => [
            'NGN' => 820,
            'EUR' => 0.89,
        ],
        'XOF' => [
            'EUR' => 0.0015,
        ],
    ],



];
