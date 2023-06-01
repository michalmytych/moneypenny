<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DenyAccessForBlockedUsers
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->isBlocked()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error' => 'Your account has been blocked by the system administration.'
                ], 403);
            }

            return redirect()->to(route('blocked.index'));
        }

        return $next($request);
    }
}
