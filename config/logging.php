<?php

use Monolog\Handler\NullHandler;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This application uses a single log file for all logging. The logs will
    | be stored in the storage/logs directory and will be rotated daily.
    |
    */

    'default' => 'single',

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | Deprecation warnings will be sent to the null channel to avoid cluttering
    | the main application logs with deprecation notices.
    |
    */

    'deprecations' => [
        'channel' => 'null',
        'trace' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. We're only
    | using a single file channel for simplicity in this API application.
    |
    */

    'channels' => [
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],
        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],
    ],
];
