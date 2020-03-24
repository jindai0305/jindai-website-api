<?php

namespace App\Http\Middleware;

use Closure;

class ConformRefreshCookieToRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has('refresh_token') && $request->hasCookie(config('website.token.refresh.name'))) {
            $request->offsetSet('refresh_token', $request->cookie(config('website.token.refresh.name')));
        }

        return $next($request);
    }
}
