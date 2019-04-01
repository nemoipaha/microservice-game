<?php

declare(strict_types=1);

final class Dice
{
    public const TOTAL_ROUNDS = 3;
    public const MIN_DICE_VALUE = 1;
    public const MAX_DICE_VALUE = 6;

    public function fight(): array
    {
        $totalRoundsWin = [
            'player1' => 0,
            'player2' => 0
        ];

        for ($i = 0; $i < self::TOTAL_ROUNDS; $i++) {
            $player1Result = random_int(self::MIN_DICE_VALUE, self::MAX_DICE_VALUE);
            $player2Result = random_int(self::MIN_DICE_VALUE, self::MAX_DICE_VALUE);
            $roundResult = $player1Result <=> $player2Result;

            if ($roundResult === 1) {
                $totalRoundsWin['player1']++;
            } elseif ($roundResult === -1) {
                $totalRoundsWin['player2']++;
            }
        }

        return $totalRoundsWin;
    }
}
