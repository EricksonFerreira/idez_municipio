<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Mailer
    |--------------------------------------------------------------------------
    |
    | This application doesn't send real emails, so we use the 'array' driver
    | which collects all emails in memory without actually sending them.
    |
    */

    'default' => 'array',

    /*
    |--------------------------------------------------------------------------
    | Mailer Configurations
    |--------------------------------------------------------------------------
    |
    | Here you may configure the mailer used by your application. We're only
    | using the 'array' driver which stores emails in memory for testing.
    |
    */

    'mailers' => [
        'array' => [
            'transport' => 'array',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Global "From" Address
    |--------------------------------------------------------------------------
    |
    | This is a default 'from' address that would be used if the application
    | were to send any emails. Since we're not sending real emails, this is
    | just a placeholder.
    |
    */

    'from' => [
        'address' => 'noreply@example.com',
        'name' => 'Municipios API',
    ],
];
