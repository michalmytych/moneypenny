<?php

namespace App\Exceptions;

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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     * Updated to return json for a request that wantsJson
     * i.e: specifies
     *      Accept: application/json
     * in its header
     */
    public function render($request, Throwable $e)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(
                $this->getJsonMessage($e),
                $this->getExceptionHTTPStatusCode($e)
            );
        }

        return parent::render($request, $e);
    }

    protected function getJsonMessage(Throwable $throwable): array
    {
        return [
            'status' => 'false',
            'message' => $throwable->getMessage()
        ];
    }

    protected function getExceptionHTTPStatusCode($e): int
    {

        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return 422;
        }

        return method_exists($e, 'getStatusCode') ? $e->getStatusCode() : 500;
    }
}
