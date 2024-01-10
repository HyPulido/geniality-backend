<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['slack', 'daily'],
        ],

        'catch_app' => [
            'driver' => 'stack',
            'channels' => [ 'app', 'slack'],
        ],
        'app' => [
            'driver' => 'daily',
            'path' => storage_path('logs/catch_app.log'),
            'level' => 'alert',
            'days' => 1,
        ],
        'error_server' => [
            'driver' => 'daily',
            'path' => storage_path('logs/error_server.log'),
            'level' => 'alert',
            'days' => 1,
        ],
        'server' => [
            'driver' => 'daily',
            'path' => storage_path('logs/server.log'),
            'level' => 'debug',
            'days' => 30,
        ],
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/lumen2.log'),
            'level' => 'debug',
        ],
        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/lumen.log'),
            'level' => 'debug',
            'days' => 7,
        ],
        'provider' => [
            'driver' => 'daily',
            'path' => storage_path('logs/provider.log'),
            'level' => 'debug',
            'days' => 7,
        ],
        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Hpulido',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],
        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'alert',
        ],
        'emergency'=>[
            'path'=> storage_path('logs/logs.log')
        ]
    ],

];
