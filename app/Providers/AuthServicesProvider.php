<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (!app()->runningInConsole()) {
            Gate::before(function ($user, $ability) {
                if ($user->isAdministrator()) {
                    return true;
                }
                return null;
            });
        }
    }
}
