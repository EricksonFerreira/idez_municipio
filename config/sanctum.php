<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Stateful Domains
    |--------------------------------------------------------------------------
    |
    | This application doesn't use Sanctum for authentication, but we keep
    | a basic configuration to avoid errors. All domains are allowed.
    |
    */

    'stateful' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Sanctum Guards
    |--------------------------------------------------------------------------
    |
    | This application doesn't use Sanctum guards for authentication.
    |
    */

    'guard' => [],

    /*
    |--------------------------------------------------------------------------
    | Expiration Minutes
    |--------------------------------------------------------------------------
    |
    | This application doesn't use Sanctum tokens, so this setting is not used.
    |
    */

    'expiration' => null,

    /*
    |--------------------------------------------------------------------------
    | Token Prefix
    |--------------------------------------------------------------------------
    |
    | This application doesn't use Sanctum tokens, so this setting is not used.
    |
    */

    'token_prefix' => '',

    /*
    |--------------------------------------------------------------------------
    | Sanctum Middleware
    |--------------------------------------------------------------------------
    |
    | This application doesn't use Sanctum middleware, but we keep a basic
    | configuration to avoid errors.
    |
    */

    'middleware' => [
        'authenticate_session' => false,
        'encrypt_cookies' => false,
        'validate_csrf_token' => false,
    ],
];
