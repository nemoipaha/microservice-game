<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

final class CheckApiKey
{
    const API_KEY = 'RSAy430_a3eGR';

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws AuthenticationException
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('api_key') !== self::API_KEY) {
            throw new AuthenticationException('Api key is invalid.');
        }

        return $next($request);
    }
}
