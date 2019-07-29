<?php

namespace Fronds\Http\Middleware;

use Closure;
use App;

class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->isSecure() && App::environment() !== 'testing' && config('fronds.security.require_https')) {
            return $next($request);
        }
    }
}
