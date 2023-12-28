<?php

namespace App\Services\Auth\Registration\OneTimeToken;

use Illuminate\Support\Str;
use App\Contracts\Infrastructure\Cache\CacheAdapterInterface;

readonly class TokenRegistrationService
{
    public function __construct(private CacheAdapterInterface $cacheAdapter) {}

    private const ONE_TIME_REGISTRATION_TOKEN_CACHE_KEY = 'auth_one_time_registration_token';

    public function generateToken(int $minutes = 15): string
    {
        $token = Str::random(64);
        $this->cacheAdapter->put(self::ONE_TIME_REGISTRATION_TOKEN_CACHE_KEY, $token, $minutes * 60);

        return $token;
    }

    public function getTokenRegistrationLink(): ?string
    {
        $cachedToken = $this->cacheAdapter->get(self::ONE_TIME_REGISTRATION_TOKEN_CACHE_KEY);
        if ($cachedToken) {
            return route('register', ['one_time_registration_token' => $cachedToken]);
        }

        return null;
    }

    public function isTokenValid(?string $token = null): bool
    {
        return $token && $token === $this->cacheAdapter->get(self::ONE_TIME_REGISTRATION_TOKEN_CACHE_KEY);
    }
}
