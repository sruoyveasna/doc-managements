<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  array<int, string>|string|null  $guards
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (auth()->check()) {
            // Redirect already-logged-in users to the dashboard (or HOME)
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
