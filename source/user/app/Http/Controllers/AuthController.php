<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

final class AuthController extends Controller
{
    public function signIn(Request $request, JWTAuth $auth): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required|string'
        ]);

        $token = $auth->attempt($request->only(['email', 'password']));

        if (! $token) {
            throw new AuthenticationException();
        }

        return response()->json([
            'access_token' => $token
        ]);
    }

    public function getAuthenticatedUser(JWTAuth $auth): JsonResponse
    {
        return response()->json($auth->user());
    }
}
