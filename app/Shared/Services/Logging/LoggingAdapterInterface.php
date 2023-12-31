<?php

namespace App\Shared\Services\Logging;

interface LoggingAdapterInterface
{
    public function debug(string $message, array $context = []): void;

    public function debugExtension(\Throwable $throwable): void;
}
