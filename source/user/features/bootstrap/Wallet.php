<?php

declare(strict_types=1);

final class Wallet implements \Countable
{
    private $cache;
    private $secrets = [];

    public function __construct(SecretsCache $cache)
    {
        $this->cache = $cache;
    }

    public function addSecret(string $secret): void
    {
        $this->secrets[] = $secret;
    }

    public function count(): int
    {
        return count($this->secrets);
    }
}
