<?php

declare(strict_types=1);

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Secret
 * @package App\Entity
 * @property string $id
 * @property string $name
 * @property string $latitude
 * @property string $longitude
 * @property string $location_name
 */
final class Secret extends Model
{
    protected $table = 'secrets';

    protected $fillable = [
        'id',
        'name',
        'latitude',
        'longitude',
        'location_name'
    ];

    public function setId(UuidInterface $uuid): void
    {
        $this->id = $uuid->toString();
    }

    public function changeName(string $name): void
    {
        $this->assertAttributeIsNotEmpty($name);

        $this->name = $name;
    }

    public function changeLocation(float $latitude, float $longitude): void
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function changeLocationName(string $locationName): void
    {
        $this->assertAttributeIsNotEmpty($locationName);

        $this->longitude = $locationName;
    }

    private function assertAttributeIsNotEmpty(string $value): void
    {
        if (empty($value)) {
            throw new \InvalidArgumentException('Empty entity attribute.');
        }
    }
}
