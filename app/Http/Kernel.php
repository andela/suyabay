<?php

namespace Suyabay\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Suyabay\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        //\Suyabay\Http\Middleware\VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'auth'         => \Suyabay\Http\Middleware\Authenticate::class,
        'auth.basic'   => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest'        => \Suyabay\Http\Middleware\RedirectIfAuthenticated::class,
        'cors'         => \Suyabay\Http\Middleware\CORS::class,
        'premium.user' => \Suyabay\Http\Middleware\premiumUser::class,
    ];
}
