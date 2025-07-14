<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Laravel's queue supports a variety of backends via a single, unified
    | API, giving you convenient access to each backend using identical
    | syntax for each. The default queue connection is defined below.
    |
    */

    'default' => 'sync',

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection options for the queue backends
    | used by your application. We're only using the 'sync' driver which
    | runs jobs immediately (synchronously).
    |
    */

    'connections' => [
        'sync' => [
            'driver' => 'sync',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging.
    | Since we're not using a database, we'll use the 'null' driver.
    |
    */

    'failed' => [
        'driver' => 'null',
    ],
];
