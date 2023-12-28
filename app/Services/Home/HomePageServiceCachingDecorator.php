<?php

namespace App\Services\Home;

use App\Models\User;
use Illuminate\Support\Collection;
use App\Contracts\Infrastructure\Cache\CacheAdapterInterface;

readonly class HomePageServiceCachingDecorator implements HomePageServiceInterface
{
    public function __construct(
        private CacheAdapterInterface $cacheAdapter,
        private HomePageService       $homePageService
    ) {
    }

    public function getHomeData(User $user): Collection
    {
        $cacheKey = 'home_page_data_user:' . $user->id;

        if ($this->cacheAdapter->missing($cacheKey)) {
            $homePageData = $this->homePageService->getHomeData($user);
            $this->cacheAdapter->set($cacheKey, $homePageData);

            return $homePageData;
        }

        return $this->cacheAdapter->get($cacheKey);
    }
}
