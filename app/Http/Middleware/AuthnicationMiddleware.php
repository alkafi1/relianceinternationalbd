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
        // Check if the current user is authenticated as a member
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            // Check if the user's status is 1
            if ($user->status == AdminStatus::APPROVED()->value) {
                return $next($request);
            }

            // If the user's status is not 1, handle accordingly
            return redirect()->route('login')->with('failed', 'Access restricted to approved admins');
        }

        // If not authenticated as member, redirect or handle accordingly
        return redirect()->route('login')->with('failed', 'Access restricted to approved admin');
    }
}
