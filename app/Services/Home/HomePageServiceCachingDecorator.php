<?php

namespace App\Services\Home;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

readonly class HomePageServiceCachingDecorator implements HomePageServiceInterface
{
    public function __construct(private HomePageService $homePageService)
    {
        // @todo write adapter for laravel cache and inject it through interface
    }

    public function getHomeData(User $user): Collection
    {
        $cacheKey = 'home_page_data_user:' . $user->id;

        if (Cache::missing($cacheKey)) {
            $homePageData = $this->homePageService->getHomeData($user);
            Cache::set($cacheKey, $homePageData);

            return $homePageData;
        }

        return Cache::get($cacheKey);
    }
}
