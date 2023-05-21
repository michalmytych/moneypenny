<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class ForceSSL
{
    public function handle(Request $request, Closure $next): Response
    {
        if (env('FORCE_SSL', false)) {
            URL::forceScheme('https');
        }

        return $next($request);
    }
}
