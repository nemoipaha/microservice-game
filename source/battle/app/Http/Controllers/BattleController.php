<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Algorithm\Dice;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class BattleController extends Controller
{
    private $dice;
    private $config;
    private $client;

    public function __construct(Dice $dice, Config $config, Client $client)
    {
        $this->dice = $dice;
        $this->config = $config;
        $this->client = $client;
    }

    public function duel(Request $request): JsonResponse
    {
        $userA = $request->input('userA');
        $userB = $request->input('userB');
        $duel = $this->dice->fight();

        try {
            $player1 = $this->getUserById($userA);
            $player2 = $this->getUserById($userB);
        } catch (BadResponseException $ex) {
            throw $ex;
        }

        return response()->json([
            'player1' => $player1,
            'player2' => $player2,
            'duelResults' => $duel
        ]);
    }

    private function getUserById(string $id): array
    {
        $response = $this->client->get(
            $this->createUserUrl($id),
            [
                'query' => [
                    'api_key' => $this->config->get('app.api_key')
                ]
            ]
        );

        return json_decode((string)$response->getBody(), true);
    }

    private function createUserUrl(string $userId): string
    {
        return sprintf('%s/%s', $this->config->get('app.user_service_url'), $userId);
    }
}
