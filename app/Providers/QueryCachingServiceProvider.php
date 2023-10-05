<?php

namespace App\Providers;

use App\Services\Home\HomePageService;
use Illuminate\Support\ServiceProvider;
use App\Services\Home\HomePageServiceInterface;
use App\Services\Home\HomePageServiceCachingDecorator;

class QueryCachingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (config('query-caching.enabled')) {
            $this->app->bind(HomePageServiceInterface::class, HomePageServiceCachingDecorator::class);

            return;
        }

        $this->app->bind(HomePageServiceInterface::class, HomePageService::class);
    }
}
