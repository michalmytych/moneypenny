<?php

namespace App\Shared\Http\Middleware;

use App\Services\Auth\Registration\OneTimeToken\TokenRegistrationService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOneTimeRegistrationToken
{
    public function __construct(private readonly TokenRegistrationService $tokenRegistrationService) {}

    public function handle(Request $request, Closure $next): Response
    {
        $isEnabled = config('auth.one_time_registration_enabled');

        if (!$isEnabled) {
            return $next($request);
        }

        $requestToken = $request->input('one_time_registration_token');
        $isTokenValid = $this->tokenRegistrationService->isTokenValid($requestToken);

        if (!$isTokenValid) {
            return redirect(route('one_time_registration_error'));
        }

        return $next($request);
    }
}
