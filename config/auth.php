<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This application doesn't use authentication, but we need to provide
    | default values for the authentication system to work properly.
    |
    */

    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | This application uses a simple token-based guard for the API, but
    | it's not actually used since we don't have authentication.
    |
    */

    'guards' => [
        'api' => [
            'driver' => 'token',
            'provider' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Since we don't have user authentication, we'll use the array driver
    | which doesn't require a database connection.
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'array',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | Password reset functionality is disabled since we don't have users
    | or authentication, but we need to provide a basic configuration.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],
];
