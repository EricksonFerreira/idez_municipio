<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This application uses the 'array' session driver, which stores the session
    | data in a simple PHP array. This is ideal for API applications that don't
    | need to persist session data between requests.
    |
    */

    'driver' => 'array',

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that you wish the session
    | to be allowed to remain idle before it expires. For the 'array' driver,
    | this is not strictly necessary since the session is lost when the script
    | ends, but it's kept for consistency with other drivers.
    |
    */

    'lifetime' => 120,
    'expire_on_close' => false,

    /*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    |
    | This option allows you to specify that all of your session data should be
    | encrypted before it's stored. Since we're using the 'array' driver,
    | encryption is not necessary as the data is never persisted to disk.
    |
    */

    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Here you may change the name of the session cookie that is created by
    | the framework. This is not strictly necessary for the 'array' driver
    | but is included for completeness.
    |
    */

    'cookie' => 'municipios_api_session',

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | The session cookie path determines the path for which the cookie will
    | be regarded as available. This will be the root path of your application.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | HTTP Access Only
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will prevent JavaScript from accessing the
    | value of the cookie and the cookie will only be accessible through
    | the HTTP protocol.
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | This option determines how your cookies behave when cross-site requests
    | take place, and can be used to mitigate CSRF attacks.
    |
    | Supported: "lax", "strict", "none", null
    |
    */

    'same_site' => 'lax',
];
