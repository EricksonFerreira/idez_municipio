<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | This application doesn't use a database, but Laravel requires this file.
    | We'll configure a minimal SQLite database in memory to satisfy the
    | framework requirements.
    |
    */

    'default' => 'sqlite',

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the database connection used by your application.
    | We're using SQLite in-memory database as a minimal configuration.
    |
    */

    'connections' => [
        'sqlite' => [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
            'foreign_key_constraints' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run.
    | Since we're not using migrations, this is just a placeholder.
    |
    */

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is not being used in this application, but we'll provide a minimal
    | configuration to satisfy the framework requirements.
    |
    */

    'redis' => [
        'client' => 'phpredis',
        'options' => [
            'cluster' => 'redis',
            'prefix' => 'municipios_api_',
        ],
        'default' => [
            'host' => '127.0.0.1',
            'port' => '6379',
            'database' => 0,
        ],
    ],
];
