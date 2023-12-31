<?php

namespace App\Providers;

use App\Services\Logging\LaravelLoggingAdapter;
use App\Services\Logging\LoggingAdapterInterface;
use Illuminate\Support\ServiceProvider;

class LoggingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LoggingAdapterInterface::class, LaravelLoggingAdapter::class);
    }
}
