<?php

namespace Suyabay\Http\Middleware;

use Closure;
use Suyabay\User;
use Suyabay\AppDetail;
use Illuminate\Http\Request;
use Suyabay\Http\Requests;
use Illuminate\Foundation\Http\Middleware\premiumUser;

class PremiumUser
{
    /**
     * declaring constant signifying to compare to the role_id
     *
    */
    const REGULAR_USER = 1;
    const PREMIUM_USER = 2;
    const SUPER_USER   = 3;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('authorization');

        if (!empty($authHeader)) {
            $appToken = AppDetail::where('api_token', '=', $authHeader)
                ->first();

            if (is_null($appToken)) {
                return response()->json(['message' => 'User unauthorized due to invalid or expired token'], 401);
            }

            if ($appToken->user->role_id === self::PREMIUM_USER || self::SUPER_USER) {
                return $next($request);
            }
        }

        return response()->json(['message' => 'User unauthorized due to empty token'], 401);
    }
}
