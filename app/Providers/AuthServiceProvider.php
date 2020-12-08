<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Http\Controllers\UserRolesController;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Passport::routes();

        Passport::tokensExpireIn(now()->addDays(1));
        Passport::refreshTokensExpireIn(now()->addDays(2));

        Gate::define('NEWS', function ($user) {
            if ($user->isAdmin()) return true;

            return UserRolesController::hasRole($user->id, 7);
        });

        Gate::define('PERSONS', function ($user) {
            if ($user->isAdmin()) return true;

            return UserRolesController::hasRole($user->id, 1);
        });

        Gate::define('TOURNAMENT', function ($user, $id) {
            if ($user->isAdmin()) return true;

            return UserRolesController::hasRole($user->id, 1);
        });

        Gate::define('TOURNLIST', function ($user) {
            if ($user->isAdmin()) return true;

            return UserRolesController::hasRole($user->id, 1);
        });

        /*Gate::define('NEWS_CREATE', function ($user, $tourn) {
            if ($user->isAdmin()) return true;

            return UserRolesController::hasTournRole($user->id, $tourn, 7);
        });*/
    }
}
