<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class UserController extends Controller
{
    public function getUsersCollection(Request $request): JsonResponse
    {
        return response()->json([
            'method' => 'index'
        ]);
    }

    public function getSingleUser(string $id, Request $request): JsonResponse
    {
        return response()->json([
            'method' => 'index',
            'id' => $id
        ]);
    }

    public function addUser(Request $request): JsonResponse
    {
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
}
