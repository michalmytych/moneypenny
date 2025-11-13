<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TouchSession
{
    public function handle(Request $request, Closure $next)
    {
        // jeśli przeglądarka nie przysłała laravel_session — „dotknij” sesji
        if (!$request->cookies->has(config('session.cookie'))) {
            $request->session()->put('_probe', Str::random(8));
        }
        return $next($request);
    }
}
