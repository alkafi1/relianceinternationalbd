<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAgentOrWebAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated as an agent
        if (Auth::guard('agent')->check()) {
            return $next($request);
        }

        // Check if the user is authenticated using the default guard (web)
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        // If neither guard is authenticated, redirect to login
        return redirect()->route('login');
    }
}
