<?php

namespace App\Shared\Providers;

use App\Moneypenny\Home\Contracts\HomePageServiceInterface;
use App\Moneypenny\Home\Services\HomePageService;
use App\Moneypenny\Home\Services\HomePageServiceCachingDecorator;
use App\Shared\Contracts\Infrastructure\Cache\CacheAdapterInterface;
use App\Shared\Services\Cache\LaravelCacheAdapter;
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
