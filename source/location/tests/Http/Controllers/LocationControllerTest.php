<?php

namespace App\Tests\Http\Controllers;

use App\Http\Controllers\LocationController;

final class LocationControllerTest extends \TestCase
{
    private const DISTANCE_LONDON_AMSTERDAM = 358.06;

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

    }
}
