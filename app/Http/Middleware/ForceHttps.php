<?php

namespace Fronds\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

/**
 * Class ForceHttps
 * @package Fronds\Http\Middleware
 * @codeCoverageIgnore system
 */
class ForceHttps
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->isSecure() && App::environment() !== 'testing' && config('fronds.security.require_https')) {
            return $next($request);
        }
    }
}
