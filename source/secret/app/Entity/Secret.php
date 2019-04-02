<?php

declare(strict_types = 1);

namespace App\Entity;

/**
 * Class Secret
 * @package App\Entity
 * @property string $id
 * @property string $name
 * @property float $latitude
 * @property float $longitude
 * @property string $location_name
 */
final class Secret extends BaseModel
{
    protected $table = 'secrets';

    protected $fillable = [
        'id',
        'name',
        'latitude',
        'longitude',
        'location_name'
    ];

    public function changeName(string $name): void
    {
        $this->assertAttributeIsNotEmpty($name);

        $this->setAttribute('name', $name);
    }

    public function changeLocation(float $latitude, float $longitude): void
    {
        $this->setAttribute('latitude', $latitude);
        $this->setAttribute('longitude', $longitude);
    }

    public function changeLocationName(string $locationName): void
    {
        $this->assertAttributeIsNotEmpty($locationName);

        $this->setAttribute('location_name', $locationName);
    }

    public function getName(): string
    {
        return $this->getAttribute('name');
    }

    public function getLatitude(): float
    {
        return $this->getAttribute('latitude');
    }

    public function getLongitude(): float
    {
        return $this->getAttribute('longitude');
    }

    public function getLocationName(): string
    {
        return $this->getAttribute('location_name');
    }
}
