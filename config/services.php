<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' => env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
        'facebook' => [
        'client_id' => '1669868613253456',
        'client_secret' => 'c4b8346601a4c99171f4653da535aed1',
        'redirect' => 'http://www.miramix-development.com/account/facebook',
    ],
       'google' => [
        'client_id'     => '649990483092-gsof9f6vtg5v1kg95mkknle69ce83s9i.apps.googleusercontent.com',
        'client_secret' => 'K3-YyyM7e-71xezXj_lqCknr',
        'redirect'      => 'http://www.miramix-development.com/account/google'
    ],

];
