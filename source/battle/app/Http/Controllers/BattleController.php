<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class BattleController extends Controller
{
    public function duel(Request $request): JsonResponse
    {
        return response()->json([]);
    }
}
