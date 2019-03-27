<?php

namespace App;

final class Dummy
{
    public $foo;

    public static $locales = [
        'en_GB',
        'en_US',
        'es_ES',
        'gl_ES'
    ];

    public static function getConfigArray(): array
    {
        return [
            'debug' => true,
            'storage' => [
                'host' => 'localhost',
                'port' => 5432,
                'user' => 'my-secret',
                'pass' => 'my-secret-password'
            ]
        ];
    }

    public static function getRandomCode(): string
    {
        return 'CODE-123A';
    }
}
