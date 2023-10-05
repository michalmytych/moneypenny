<?php

namespace App\Services\Cache;

use App\Models\User;
use Opcodes\LogViewer\Facades\Cache;

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
}
