<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;

final class LocationController
{
    private const ROUND_DECIMALS = 2;
    private const KM = 'km';

    public const MAX_CLOSEST_SECRETS = 3;

    private static $conversionRates = [
        'km' => 1.853159616,
        'mile' => 1.1515
    ];

    private const CACHE_SECRETS = [
        [
            'id' => 100,
            'name' => 'amber',
            'location' => [
                'latitude' => 42.8805,
                'longitude' => -8.54569,
                'name' => 'Santiago de Compostela'
            ]
        ],
        [
            'id' => 101,
            'name' => 'diamond',
            'location' => [
                'latitude' => 38.2622,
                'longitude' => -0.70107,
                'name' => 'Elche'
            ]
        ],
        [
            'id' => 102,
            'name' => 'pearl',
            'location' => [
                'latitude' => 41.8919,
                'longitude' => 12.5113,
                'name' => 'Rome'
            ]
        ],
        [
            'id' => 103,
            'name' => 'ruby',
            'location' => [
                'latitude' => 53.4106,
                'longitude' => -2.9779,
                'name' => 'Liverpool'
            ]
        ],
        [
            'id' => 104,
            'name' => 'sapphire',
            'location' => [
                'latitude' => 50.08804,
                'longitude' => 14.42076,
                'name' => 'Prague'
            ]
        ]
    ];

    private const DEFAULT_CACHE_TIME = 100;

    private $cache;
    private $validator;

    public function __construct(Repository $cache, Factory $validator)
    {
        $this->cache = $cache;
        $this->validator = $validator;
    }

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

    public function getClosestSecrets(Request $request): JsonResponse
    {
        $this->validator->validate($request->all(), [
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $originPoint = [
            'latitude' => (float)$request->query('latitude'),
            'longitude' => (float)$request->query('longitude'),
        ];

        $cacheKey = sprintf('L%s%s', $originPoint['latitude'], $originPoint['longitude']);

        $data = $this->cache->remember(
            $cacheKey,
            self::DEFAULT_CACHE_TIME,
            function () use($originPoint) {
                return $this->getClosestSecretsAction($originPoint);
            }
        );

        return response()->json($data);
    }

    private function getClosestSecretsAction(array $originPoint): array
    {
        $preprocessClosure = function(array $item) use($originPoint): float {
            return $this->getHaversineDistance($item['location'], $originPoint);
        };

        $distances = array_map($preprocessClosure, $this->loadSecrets());

        asort($distances);

        $distances = array_slice($distances, 0, self::MAX_CLOSEST_SECRETS, true);

        $secrets = [];

        array_walk(
            $distances,
            function(float $distance, int $key) use(&$secrets): void {
                $secrets[] = self::CACHE_SECRETS[$key];
            }
        );

        return $secrets;
    }

    /**
     * @todo call secrets microservice
     * @return array
     */
    private function loadSecrets(): array
    {
        return self::CACHE_SECRETS;
    }
}
