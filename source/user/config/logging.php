<?php

use Sentry\Laravel\LogChannel;

return [
    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily'],
        ],

        'sentry' => [
            'driver' => 'monolog',
            'via' => LogChannel::class
        ]
    ]
];

