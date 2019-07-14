<?php

declare(strict_types=1);

namespace App\Http\Response;

use App\Exceptions\ErrorCodeGenerator;
use Illuminate\Http\JsonResponse;

final class ApiResponse extends JsonResponse
{
    public static function success(array $data = []): self
    {
        return new static([
            'data' => $data
        ]);
    }

    public static function error(string $message, string $code = ErrorCodeGenerator::VALIDATION_ERROR_CODE): self
    {
        return new static([
            'errors' => [
                [
                    'code' => $code,
                    'message' => $message
                ]
            ]
        ], 400);
    }

    public static function empty(): self
    {
        return new static();
    }
}
