<?php

return [
    'domain' => domain(),

    /*
    |--------------------------------------------------------------------------
    | Partner's sub domain
    |--------------------------------------------------------------------------
    |
    | It is important to fetch the partner domain from the url.
    | If no sub domain given than the default domain will be null
    |
    */
    'partner' => sub_domain() ?: env('DEFAULT_PARTNER'),

    /*
    |--------------------------------------------------------------------------
    | Domains which are reserved
    |--------------------------------------------------------------------------
    |
    | Here you can list all the domains which should not be use by any partner
    | You by default as a system administrator it is reserve by other services.
    |
    */
    'reserve-domains' => [
        'www',
    ],

    'partner.connection' => [
        'driver' => 'mysql',
        'host' => env('DB_HOST', '127.0.0.1'),
        'port' => env('DB_PORT', '3306'),
        'database' => config('multi-tenant.partner'),
        'username' => env('DB_USERNAME', 'forge'),
        'password' => env('DB_PASSWORD', ''),
        'unix_socket' => env('DB_SOCKET', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'strict' => true,
        'engine' => null,
    ]
];
