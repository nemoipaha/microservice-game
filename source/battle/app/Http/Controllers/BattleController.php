<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Algorithm\Dice;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class BattleController extends Controller
{
    private $dice;

    public function __construct(Dice $dice)
    {
        $this->dice = $dice;
    }

    public function duel(Request $request): JsonResponse
    {
        $duel = $this->dice->fight();

        return response()->json([
            'player1' => $request->input('userA'),
            'player2' => $request->input('userB'),
            'duelResults' => $duel
        ]);
    }
}
