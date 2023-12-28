<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(
            function (Throwable $e) {
                //
            }
        );
    }

    /**
     * Render an exception into an HTTP response.
     * Updated to return json for a request that wantsJson
     * i.e: specifies
     *      Accept: application/json
     * in its header
     */
    public function render($request, Throwable $e): JsonResponse|RedirectResponse|Response
    {
        if ($request->ajax() || $request->is('api/*') || $request->wantsJson()) {
            return $this->getJsonResponse($e);
        }

        return parent::render($request, $e);
    }

    protected function getJsonResponse(Throwable $throwable): JsonResponse
    {
        $statusCode = $this->getExceptionHTTPStatusCode($throwable);

        return new JsonResponse(
            [
            'status' => $statusCode,
            'message' => $throwable->getMessage()
            ], $statusCode
        );
    }

    protected function getExceptionHTTPStatusCode(Throwable $throwable): int
    {
        return match (true) {
            $throwable instanceof BadRequestException => 400,
            $throwable instanceof UnauthorizedException => 403,
            $throwable instanceof AuthenticationException => 401,
            $throwable instanceof ValidationException => 422,
            $throwable instanceof TooManyRequestsHttpException => 429,
            default => 500,
        };
    }
}
