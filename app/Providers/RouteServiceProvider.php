<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * This is where users are redirected after login, or when
     * a guest middleware tries to redirect an already-authenticated user.
     */
    public const HOME = '/dashboard';

    /**
     * Register any route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        // You can add route model bindings here if you ever need them.
        // For now we don't need anything – routes are configured in bootstrap/app.php.
    }
}
