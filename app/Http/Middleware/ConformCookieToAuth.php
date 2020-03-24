<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConformCookieToAuth
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
        if (!$this->hasValidAuthorization($request) && $request->hasCookie(config('website.token.access.name'))) {
            $request->headers->set('Authorization', config('website.token.bearer') . $request->cookie(config('website.token.access.name')));
        }

        if ($request->hasHeader('X_FORWARDED_FOR')) {
            $request->setTrustedProxies($request->getClientIps(), Request::HEADER_X_FORWARDED_FOR);
        }

        return $next($request);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function hasValidAuthorization($request)
    {
        if (!$request->hasHeader('Authorization')) {
            return false;
        }

        $authorization = $request->header('Authorization');
        if (!Str::startsWith($authorization, config('website.token.bearer'))) {
            return false;
        }

        return strlen($authorization) > config('website.token.min_length');
    }
}
