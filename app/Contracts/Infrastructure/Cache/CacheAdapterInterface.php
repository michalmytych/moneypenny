<?php

namespace App\Contracts\Infrastructure\Cache;

use DateInterval;
use App\Models\User;

interface CacheAdapterInterface
{
    public function getUserCacheKeys(User $user): array;

    public function clearUserCache(User $user): void;

    public function get(array|string $key, mixed $default = null): mixed;

    public function set(string $key, mixed $value, DateInterval|int|null $ttl = null): bool;

    public function forget(string $key): bool;

    public function missing(string $cacheKey): bool;

    public function put(string $cacheKey, mixed $content);

    public function has(array|string $cacheKey): bool;
}
