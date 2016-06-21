<?php

namespace Suyabay\Http\Middleware;

use Auth;
use Closure;

class PreventRegularUsers
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
        if (Auth::user()->role_id == 1) {
            return abort(401);
        }

        return $next($request);
    }
}
