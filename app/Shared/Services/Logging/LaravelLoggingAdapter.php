<?php

namespace App\Shared\Services\Logging;

use Illuminate\Support\Facades\Log;

class LaravelLoggingAdapter implements LoggingAdapterInterface
{
    public function debug(string $message, array $context = []): void
    {
        Log::debug($message, $context);
    }

    public function debugExtension(\Throwable $throwable): void
    {
        $this->debug($throwable->getMessage() . ', ' . $throwable->getTraceAsString());
    }
}
