<?php

declare(strict_types=1);

namespace App\Http\Transformer;

use App\Entity\Secret;
use League\Fractal\TransformerAbstract;

final class SecretTransformer extends TransformerAbstract
{
    public function transform(Secret $secret): array
    {
        return [
            'id' => $secret->getId(),
            'name' => $secret->getName(),
            'location' => [
                'latitude' => $secret->getLatitude(),
                'longitude' => $secret->getLongitude(),
                'location_name' => $secret->getLocationName()
            ]
        ];
    }
}
