<?php

namespace App\Http\Middleware;

use Closure;

class RequestRecord
{
    protected $start;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->start = microtime(true);
        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $response
     */
    public function terminate($request, $response)
    {
        if (!config('except.open')) {
            return;
        }
        dispatch(new \App\Jobs\RequestRecord($request, $this->start, $response));
    }
}
