<?php

namespace Suyabay\Providers;

use Suyabay\User;
use Suyabay\Role;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Suyabay\Model' => 'Suyabay\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies($gate);

        //Regular user can upgrade
        $gate->define('see-upgrade', function ($user) {
            return $user->role->name === 'Regular User';
        });

        //Regular user can't see dashboard
        $gate->define('see-dashboard', function ($user) {
            return $user->role->name !== 'Regular User';
        });

        // Super admin role
        $gate->define('super-admin', function($user) {
            return $user->role->name === 'Super Admin';
        });
    }
}
