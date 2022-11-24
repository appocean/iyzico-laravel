<?php

return [
    'name' => 'Payment',
    'models' => [
        'user' => 'App\\Models\\User'
    ],

    'nova_resources' => [
        \Appocean\Payment\Nova\Plan::class,
        \Appocean\Payment\Nova\PlanSubscription::class,
        \Appocean\Payment\Nova\Product::class

    ],

    'api_resources' => [

    ],
    'api-key' => env('IYZICO_API_KEY'),
    'secret-key' => env('IYZICO_SECRET_KEY'),
    'base-url' => env('IYZICO_BASE_URL'),
    'sync_trial_day_with_the_payment_provider' => env('SYNC_TRIAL_DAY_WITH_THE_PAYMENT_PROVIDER', true)
];
