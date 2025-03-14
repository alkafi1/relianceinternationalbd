<?php

namespace App\Http\Middleware;

use App\Enums\AgentStatus;
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
        // Check if the current user is authenticated as a member
        if (Auth::guard('agent')->check()) {
            $agent = Auth::guard('member')->user();

            // Check if the user's status is 1
            if ($agent->status == AgentStatus::APPROVED()->value) {
                return $next($request);
            }

            // If the user's status is not 1, handle accordingly
            return redirect()->route('agent.login')->with('failed', 'Access restricted to approved members');
        }

        // If not authenticated as member, redirect or handle accordingly
        return redirect()->route('agent.login')->with('failed', 'Login is required for comment');
    }
}
