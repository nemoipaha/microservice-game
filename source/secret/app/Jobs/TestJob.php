<?php

declare(strict_types=1);

namespace App\Jobs;

final class TestJob extends Job
{
    private $key;

    public function __construct(string $key)
    {
        if (empty($key)) {
            throw new \InvalidArgumentException('Key is empty.');
        }

        $this->key = $key;
    }

    public function handle(): void
    {
        var_dump($this->key);
    }
}
