<?php

namespace App\Http\Middleware;

use App\Enums\AdminStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthnicationMiddleware
{
    /**
     * Handle an incoming request and ensure the user is authenticated and approved.
     *
     * This middleware will check if the user is authenticated and has the approved status.
     * If the user is not authenticated or not approved, it will redirect to the login page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is not authenticated or not approved
        if (Auth::check() && Auth::user()->status === AdminStatus::APPROVED()->value) {
            // If the user is authenticated and approved, let the request pass through
            return $next($request);
        }

        // If the user is not authenticated or not approved, redirect to the login page
        return redirect()->route('login')->withErrors(['message' => 'User not authorized.']);
        return redirect()->route('login');
    }
}
