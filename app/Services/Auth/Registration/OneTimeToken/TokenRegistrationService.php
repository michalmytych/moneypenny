<?php

namespace App\Services\Auth\Registration\OneTimeToken;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class TokenRegistrationService
{
    private const ONE_TIME_REGISTRATION_TOKEN_CACHE_KEY = 'one_time_registration_token';

    public function generateToken(int $minutes = 15): string
    {
        $token = Str::random(64);
        Cache::put(self::ONE_TIME_REGISTRATION_TOKEN_CACHE_KEY, $token, $minutes * 60);
        return $token;
    }

    public function getTokenRegistrationLink(): ?string
    {
        $cachedToken = Cache::get(self::ONE_TIME_REGISTRATION_TOKEN_CACHE_KEY);
        if ($cachedToken) {
            return route('register', ['one_time_registration_token' => $cachedToken]);
        }
        return null;
    }

    public function isTokenValid(?string $token = null): bool
    {
        return $token && $token === Cache::get(self::ONE_TIME_REGISTRATION_TOKEN_CACHE_KEY);
    }
}
