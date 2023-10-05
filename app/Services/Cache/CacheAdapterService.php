<?php

namespace App\Services\Cache;

use DateInterval;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class CacheAdapterService
{
    public function getUserCacheKeys(User $user): array
    {
        return [
            'home_page_data_user:' . $user->id
        ];
    }

    public function clearUserCache(User $user): void
    {
        $keysToForget = $this->getUserCacheKeys($user);

        foreach ($keysToForget as $key) {
            Cache::forget($key);
        }
    }

    public function get(array|string $key, mixed $default = null): mixed
    {
        return Cache::get($key, $default);
    }

    public function set(string $key, mixed $value, DateInterval|int|null $ttl = null): bool
    {
        return Cache::set($key, $value, $ttl);
    }

    public function forget(string $key): bool
    {
        return Cache::forget($key);
    }

    public function missing(string $cacheKey): bool
    {
        return Cache::missing($cacheKey);
    }
}
