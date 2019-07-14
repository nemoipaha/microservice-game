<?php

declare(strict_types=1);

final class SecretsCache
{
    private $map = [];

    public function setSecret(string $secret)
    {
        $this->map[$secret] = $secret;
    }

    public function getSecret(string $secret)
    {
        return $this->map[$secret];
    }
}
