<?php

namespace App\Providers;

use App\Contracts\Infrastructure\Cache\CacheAdapterInterface;
use App\Services\Cache\LaravelCacheAdapter;
use App\Services\Home\HomePageService;
use App\Services\Home\HomePageServiceCachingDecorator;
use App\Services\Home\HomePageServiceInterface;
use Illuminate\Support\ServiceProvider;

class QueryCachingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CacheAdapterInterface::class, LaravelCacheAdapter::class);

        if (config('query-caching.enabled')) {
            $this->app->bind(HomePageServiceInterface::class, HomePageServiceCachingDecorator::class);

            return;
        }

        $this->app->bind(HomePageServiceInterface::class, HomePageService::class);
    }
}
