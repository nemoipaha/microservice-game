<?php

namespace App\Tests\Http\Controllers;

use App\Http\Controllers\LocationController;

final class LocationControllerTest extends \TestCase
{
    private const DISTANCE_LONDON_AMSTERDAM = 358.06;
    private const CURRENT_LOCATION = [
        'latitude' => 40.730610,
        'longitude' => -73.935242
    ];

    public function testDistance()
    {
        $london = [
            'latitude' => 51.50,
            'longitude' => -0.13
        ];

        $amsterdam = [
            'latitude' => 52.37,
            'longitude' => 4.90
        ];

        $locationCtrl = new LocationController();

        $distance = $locationCtrl->getDistance($london, $amsterdam);

        $this->assertClassHasStaticAttribute('conversionRates', LocationController::class);
        $this->assertEquals(self::DISTANCE_LONDON_AMSTERDAM, $distance);
    }

    public function testClosestSecrets()
    {
        $locationCtrl = new LocationController();

        $closestSecrets = $locationCtrl->getClosestSecrets(self::CURRENT_LOCATION);

        $this->assertClassHasStaticAttribute('conversionRates', LocationController::class);
        $this->assertContainsOnly('array', $closestSecrets);
        $this->assertCount(LocationController::MAX_CLOSEST_SECRETS, $closestSecrets);

        $current = array_shift($closestSecrets);
        $this->assertArraySubset(['name' => 'amber'], $current);

        $current = array_shift($closestSecrets);
        $this->assertArraySubset(['name' => 'ruby'], $current);

        $current = array_shift($closestSecrets);
        $this->assertArraySubset(['name' => 'diamond'], $current);
    }
}
