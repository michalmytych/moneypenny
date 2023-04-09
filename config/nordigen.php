<?php

return [
    'base_uri'              => env('NORDIGEN_API_BASE_URL'),
    'secret_id'             => env('NORDIGEN_API_SECRET_ID'),
    'secret_key'            => env('NORDIGEN_API_SECRET_KEY'),
    'country'               => 'pl',
    'payments_enabled'      => false,
    'max_historical_days'   => 90,
    'access_valid_for_days' => 30,
    'user_language'         => 'PL',
    'headers'               => [
        'Accept'       => 'application/json',
        'Content-Type' => 'application/json',
    ],
];
