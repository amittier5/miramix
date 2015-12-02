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
    //     'facebook' => [
    //     'client_id' => '1712231159008324',
    //     'client_secret' => 'cfaefc82fe22a30a071960c46d09362f',
    //     'redirect' => 'http://www.miramix-development.com/account/facebook',
    // ],
    //    'google' => [
    //     'client_id'     => '649990483092-gsof9f6vtg5v1kg95mkknle69ce83s9i.apps.googleusercontent.com',
    //     'client_secret' => 'K3-YyyM7e-71xezXj_lqCknr',
    //     'redirect'      => 'http://www.miramix-development.com/account/google'
    // ],

    /*'facebook' => [
        'client_id' => '1712231159008324',
        'client_secret' => 'cfaefc82fe22a30a071960c46d09362f',
        'redirect' => 'http://www.miramix.com/account/facebook',
    ],
       'google' => [
        'client_id'     => '649990483092-gsof9f6vtg5v1kg95mkknle69ce83s9i.apps.googleusercontent.com',
        'client_secret' => 'K3-YyyM7e-71xezXj_lqCknr',
        'redirect'      => 'http://www.miramix.com/account/google'
    ],*/

     'facebook' => [
        'client_id' => '1494855380830024',
        'client_secret' => '86def9d21b7d42a71b41d743b044c0e7',
        'redirect' => 'http://www.miramix.com/account/facebook',
    ],
       'google' => [
        'client_id'     => '645160792188-vd95504d5uakqndc95mklkmnbaus91gd.apps.googleusercontent.com',
        'client_secret' => 'hGGrmZTNwhTKmwjcy8Uguyhr',
        'redirect'      => 'http://www.miramix.com/account/google'
    ],

];
