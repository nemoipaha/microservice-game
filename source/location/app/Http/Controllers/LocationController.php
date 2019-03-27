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
        return $this->getHaversineDistance($pointA, $pointB, $unit);
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

    private function getHaversineDistance(array $pointA, array $pointB, string $unit = self::KM): float
    {
        $distance = rad2deg(
            acos(
                sin(deg2rad($pointA['latitude'])) * sin(deg2rad($pointB['latitude']))
                + (
                    cos(deg2rad($pointA['latitude']))
                    * cos(deg2rad($pointB['latitude']))
                    * cos(deg2rad($pointA['longitude'] - $pointB['longitude']))
                )
            )
        ) * 60;

        return $this->convertDistance($distance, $unit);
    }
}
