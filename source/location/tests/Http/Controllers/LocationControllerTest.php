<?php

namespace App\Tests\Http\Controllers;

use App\Http\Controllers\LocationController;
use Illuminate\Http\Request;

final class LocationControllerTest extends \TestCase
{
    private const DISTANCE_LONDON_AMSTERDAM = 358.06;
    private const CURRENT_LOCATION = [
        'latitude' => 40.730610,
        'longitude' => -73.935242
    ];

    /**
     * @var LocationController
     */
    private $locationCtrl;

    protected function setUp(): void
    {
        parent::setUp();

        $this->locationCtrl = $this->app->make(LocationController::class);
    }

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

        $distance = $this->locationCtrl->getDistance($london, $amsterdam);

        $this->assertClassHasStaticAttribute('conversionRates', LocationController::class);
        $this->assertEquals(self::DISTANCE_LONDON_AMSTERDAM, $distance);
    }

    public function testClosestSecrets()
    {
        $closestSecrets = $this->locationCtrl->getClosestSecrets(new Request(self::CURRENT_LOCATION));
        $closestSecrets = $closestSecrets->getData(true);

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
