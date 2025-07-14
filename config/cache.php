<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This application uses the 'array' cache driver by default, which stores
    | the cached data in memory and is cleared when the application ends.
    |
    */

    'default' => 'array',

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define the cache stores for your application. We're only
    | using the 'array' driver which stores items in memory.
    |
    */

    'stores' => [
        'array' => [
            'driver' => 'array',
            'serialize' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | This prefix is used to avoid cache key collisions with other applications
    | using the same cache. Since we're only using the 'array' driver, this
    | is not strictly necessary but kept for consistency.
    |
    */

    'prefix' => 'municipios_api_',
];
