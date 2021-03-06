<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Jobs\GiftJob;
use App\Jobs\TestJob;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Queue\QueueManager;
use Illuminate\Contracts\Bus\Dispatcher;
use Psr\Log\LoggerInterface;

final class UserController extends Controller
{
    private $users = [
        1 => [
            'name' => 'John',
            'city' => 'Barcelona'
        ],
        2 => [
            'name' => 'Joe',
            'city' => 'Paris'
        ]
    ];

    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getUsersCollection(Request $request): JsonResponse
    {
        return response()->json([
            'method' => 'index'
        ]);
    }

    /**
     * Test sentry logs
     */
    public function getSingleUser(string $id, Request $request, LoggerInterface $logger): JsonResponse
    {
        $logger->debug('debug', ['key' => 'privet']);

        return response()->json($this->users[$id]);
    }

    public function addUser(Request $request): JsonResponse
    {
        $this->dispatch(new GiftJob());

        return response()->json([
            'method' => 'add_user'
        ]);
    }

    public function updateUser(Request $request): JsonResponse
    {
        return response()->json([
            'method' => 'update_user'
        ]);
    }

    public function deleteUser(string $id, Request $request): JsonResponse
    {
        return response()->json([
            'method' => 'delete_user',
            'id' => $id
        ]);
    }

    public function getUserCurrentLocation(string $id, Request $request): JsonResponse
    {
        return response()->json([
            'method' => 'get_user_current_location',
            'id' => $id
        ]);
    }

    public function changeUserCurrentLocation(
        string $id,
        string $latitude,
        string $longitude,
        Request $request
    ): JsonResponse {
        return response()->json([
            'method' => 'change_user_current_location',
            'id' => $id,
            'latitude' => $latitude,
            'longitude' => $longitude,
        ]);
    }

    public function getUserWallet(): JsonResponse
    {
        // @todo refactor to repository and use secret entity
        $data = $this->client
            ->get(
                // @todo remove hardcoded secret id
                sprintf('http://microservice_secret_nginx/api/v1/secrets/%s', '0402b520-9873-4abb-a83d-d1c8e612be1c')
            )
            ->getBody()
            ->getContents();

        return response()->json(json_decode($data));
    }

    /**
     * @todo refactor
     *
     * @param Request $request
     * @param Dispatcher $dispatcher
     * @return JsonResponse
     */
    public function sendQueueMessage(
        Request $request,
        Dispatcher $dispatcher
    ): JsonResponse {
        $dispatcher->dispatch(new TestJob($request->query('key')));

//        $queueManager = app(QueueManager::class);
//
//        $queueManager->connection('sqs')->push(new TestJob($request->query('key')));

        return response()->json(null);
    }
}
