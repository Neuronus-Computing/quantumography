<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user has the 'admin' role
        if (auth()->check() && auth()->user()->role == 'admin') {
            return $next($request); // User is an admin, proceed with the request.
        }

        // User is not an admin, redirect to the dashboard route.
        return redirect()->route('dashboard');    
    }
}
