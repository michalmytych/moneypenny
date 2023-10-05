<?php

namespace App\Services\Home;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Services\Cache\CacheAdapterService;

readonly class HomePageServiceCachingDecorator implements HomePageServiceInterface
{
    public function __construct(
        private HomePageService $homePageService,
        // @todo - implement everywhere instead of using Cache facade directly
        private CacheAdapterService $cacheAdapterService
    )
    {
        // @todo write adapter for laravel cache and inject it through interface
    }

    public function getHomeData(User $user): Collection
    {
        $cacheKey = 'home_page_data_user:' . $user->id;

        if ($this->cacheAdapterService->missing($cacheKey)) {
            $homePageData = $this->homePageService->getHomeData($user);
            $this->cacheAdapterService->set($cacheKey, $homePageData);

            return $homePageData;
        }

        return $this->cacheAdapterService->get($cacheKey);
    }
}
