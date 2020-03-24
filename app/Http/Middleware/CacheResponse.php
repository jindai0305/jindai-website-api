<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheResponse
 * @package App\Http\Middleware
 */
class CacheResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param integer $minutes
     * @return mixed
     */
    public function handle($request, Closure $next, $minutes = 30)
    {
        if (config('app.debug')) {
            return $next($request);
        }

        if ($minutes < 0) {
            $response = Cache::rememberForever($this->cacheKey($request), function () use ($request, $next) {
                return $next($request)->getContent();
            });
        } else {
            $response = Cache::remember($this->cacheKey($request), $minutes, function () use ($request, $next) {
                return $next($request)->getContent();
            });
        }
        return response()->json($this->prepareContent($response));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function cacheKey($request)
    {
        return build_cache_key($request->route()->uri);
    }

    /**
     * @param $string
     * @return mixed
     */
    protected function prepareContent($string)
    {
        $jsonResponse = json_decode($string);
        if (null === $jsonResponse) {
            return $string;
        }
        return $jsonResponse;
    }
}
