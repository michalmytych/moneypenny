<?php

namespace App\Shared\Providers;

use App\Shared\Services\Logging\LaravelLoggingAdapter;
use App\Shared\Services\Logging\LoggingAdapterInterface;
use Illuminate\Support\ServiceProvider;

class LoggingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LoggingAdapterInterface::class, LaravelLoggingAdapter::class);
    }
}
