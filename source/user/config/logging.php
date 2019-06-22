<?php

return [

    'default' => env('LOG_CHANNEL', 'stack'),

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => [
                'daily',
                'sentry'
            ],
        ],

        'sentry' => [
            'driver' => 'sentry',
            'level' => 'debug',
        ]
    ],

];
