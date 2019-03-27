<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

final class LocationController
{
    private const ROUND_DECIMALS = 2;
    private const KM = 'km';

    public static $conversionRates = [
        'km' => 1.853159616,
        'mile' => 1.1515
    ];

    public function getDistance(array $pointA, array $pointB, string $unit = self::KM): float
    {
        return $this->getEuclideanDistance($pointA, $pointB, $unit);
    }

    private function convertDistance(float $distance, string $unit = self::KM): float
    {
        switch (strtolower($unit)) {
            case 'mile':
                $distance *= self::$conversionRates['mile'];
                break;

            default:
                $distance *= self::$conversionRates['km'];
        }

        return round($distance, self::ROUND_DECIMALS);
    }

    private function getEuclideanDistance(array $pointA, array $pointB, string $unit = self::KM): float
    {
        $distance = sqrt(
            pow(abs($pointA['latitude'] - $pointB['latitude']), 2) + pow(abs($pointA['longitude'] - $pointB['longitude']), 2)
        );

        return $this->convertDistance($distance, $unit);
    }
}
