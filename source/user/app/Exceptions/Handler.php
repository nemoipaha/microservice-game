<?php

namespace App\Exceptions;

use Exception;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Response;
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
        if ($this->shouldReport($exception) && app()->bound('sentry')) {
            app('sentry')->captureException($exception);
        }

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
        if ($exception instanceof ConnectException || $exception instanceof ServerException) {
            return response()->json([
                'errors' => [
                    'code' => 'connection_error',
                    'message' => 'Server responded with an error.'
                ]
            ], Response::HTTP_SERVICE_UNAVAILABLE);
        }

        if ($exception instanceof BadResponseException) {
            return response()->json([
                'errors' => [
                    'code' => 'invalid_request',
                    'message' => $exception->getMessage()
                ]
            ], $exception->getResponse()->getStatusCode());
        }

        if ($exception instanceof AuthenticationException) {
            return response()->json([
                'errors' => [
                    'code' => 'unauthenticated',
                    'message' => 'Unauthenticated.'
                ]
            ], 401);
        }

        return parent::render($request, $exception);
    }
}
