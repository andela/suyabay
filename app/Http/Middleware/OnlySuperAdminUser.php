<?php

namespace Suyabay\Http\Middleware;

use Auth;
use Closure;

class OnlySuperAdminUser
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
        if (Auth::user()->role_id != 3) {
            return abort(401);
        }

        return $next($request);
    }
}
