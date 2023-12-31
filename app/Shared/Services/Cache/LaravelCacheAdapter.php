<?php

namespace App\Shared\Services\Cache;

use App\Moneypenny\User\Models\User;
use App\Shared\Contracts\Infrastructure\Cache\CacheAdapterInterface;
use DateInterval;
use DateTimeInterface;
use Illuminate\Support\Facades\Cache;

class LaravelCacheAdapter implements CacheAdapterInterface
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

    public function put(string|array $cacheKey, mixed $content, DateInterval|DateTimeInterface|int|null $ttl = null): bool
    {
        return Cache::put($cacheKey, $content, $ttl);
    }

    public function has(array|string $cacheKey): bool
    {
        return Cache::has($cacheKey);
    }
}
