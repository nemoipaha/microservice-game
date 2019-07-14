<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            return response()->json([
                'errors' => Collection::make($exception->validator->errors()->keys())
                    ->map(
                        function (string $errorKey) use($exception) {
                            return [
                                'parameter' => $errorKey,
                                'code' => 'invalid_parameter',
                                'message' => $exception->validator->errors()->first($errorKey)
                            ];
                        }
                    )
                    ->all()
            ], 400);
        }

        return parent::render($request, $exception);
    }
}
