<?php
return [
    
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'google' => [
        'client_id' => '553917271501-u4tjlom63hotel7o6ro3g0vdvo37c087.apps.googleusercontent.com',         // Your GitHub Client ID
        'client_secret' => 'OZzguN87aeWUkDRb_AQeQNbx', // Your GitHub Client Secret
        // 'redirect' => 'http://localhost:9000/login/google/callback',
        'redirect' => 'http://laravelweb.corp.solarphilippines.ph:9000/login/google/callback',
    ],
];
