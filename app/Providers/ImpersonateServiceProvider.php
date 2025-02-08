<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ImpersonateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Blade::if('me', function ($user) {
            return (User::isImpersonating() && $user->realUser()->id === $user->id) ||
                (! User::isImpersonating() && auth()->id() === $user->id);
        });

        Blade::if('notMe', function ($user) {
            return ! (User::isImpersonating() && $user->realUser()->id === $user->id) &&
                ! (! User::isImpersonating() && auth()->id() === $user->id);
        });

        Blade::if('canImpersonate', fn () => auth()->user()->canImpersonate());

        Blade::if('canBeImpersonated', fn ($user) => $user->canBeImpersonated());

        Blade::if('isImpersonating', fn () => User::isImpersonating());

        Blade::if('isImpersonatingTo', fn ($user) => $user->realUser()->isImpersonatingTo($user));
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
