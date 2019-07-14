<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class OAuthController
{
    public function getData(Request $request): JsonResponse
    {
        return response()->json(['data' => mt_rand()]);
    }
}
