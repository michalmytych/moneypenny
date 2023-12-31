<?php

namespace App\Moneypenny\Home\Services;

use App\Moneypenny\User\Models\User;
use App\Shared\Contracts\Infrastructure\Cache\CacheAdapterInterface;
use Illuminate\Support\Collection;

readonly class HomePageServiceCachingDecorator implements HomePageServiceInterface
{
    public function __construct(
        private CacheAdapterInterface $cacheAdapter,
        private HomePageService       $homePageService
    )
    {
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
