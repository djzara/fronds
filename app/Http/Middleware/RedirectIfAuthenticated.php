<?php

namespace Fronds\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class RedirectIfAuthenticated
 * @package Fronds\Http\Middleware
 * @codeCoverageIgnore system
 */
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {


        return $next($request);
    }
}
