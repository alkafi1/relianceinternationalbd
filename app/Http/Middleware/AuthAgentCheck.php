<?php

namespace App\Http\Middleware;

use App\Enums\AdminStatus;
use App\Enums\AgentStatus;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthAgentCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Check if the user is not authenticated or not approved
        if (Auth::guard('agent')->check() && Auth::guard('agent')->user()->status === AgentStatus::APPROVED()->value) {
            // If the user is authenticated and approved, let the request pass through
            return $next($request);
        }

        // If the user is not authenticated or not approved, redirect to the login page
        return redirect()->route('agent.login')->withErrors(['message' => 'Agent not authorized.']);
    }
}
