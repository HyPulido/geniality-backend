<?php


return [

    'default'  => getenv('DB_DATABASE'),
    'migrations' => 'migrations',

    'connections'  => [
        getenv('DB_DATABASE')  => [
            'driver'     => 'mysql',
            'host'       => env('DB_HOST', 'localhost'),
            'database'   => env('DB_DATABASE', 'forge'),
            'username'   => env('DB_USERNAME', 'forge'),
            'password'   => env('DB_PASSWORD', ''),
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'     => '',
            'strict'     => false,
        ],
    ]
];
