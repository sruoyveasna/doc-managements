<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(
    basePath: dirname(__DIR__),
)
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Optional: extra web middleware
        // $middleware->web(append: [
        //     // \Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets::class,
        // ]);

        // Route middleware aliases used in routes (auth, can, etc.)
        $middleware->alias([
            'auth'     => \App\Http\Middleware\Authenticate::class,
            'guest'    => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'can'      => \Illuminate\Auth\Middleware\Authorize::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
