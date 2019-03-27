<?php

namespace App;

class Dummy
{
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
}
