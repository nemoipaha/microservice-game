<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

abstract class BaseModel extends Model
{
    protected $keyType = 'string';

    public $incrementing = false;

    public function setAttribute($key, $value)
    {
        if ($key === $this->getKeyName()) {
            $value = (string)$value;
            $this->assertIdFormat($value);
        }

        parent::setAttribute($key, $value);
    }

    public function setId(UuidInterface $uuid): void
    {
        $this->setAttribute('id', $uuid->toString());
    }

    public function getId(): string
    {
        return $this->getAttribute('id');
    }

    private function assertIdFormat(string $value): void
    {
        try {
            Uuid::fromString($value);
        } catch (InvalidUuidStringException $ex) {
            throw new \BadMethodCallException('Invalid uuid format.');
        }
    }

    protected function assertAttributeIsNotEmpty(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Empty entity attribute.');
        }
    }
}
