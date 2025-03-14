<?php

namespace App\Services;

use App\Enums\AdminStatus;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AgentLoginService
{
    /**
     * Attempt to log in a user.
     *
     * @param array $credentials
     * @return array|null
     */
    public function login(array $credentials): ?array
    {
        // Attempt to log the user in
        if (Auth::guard('agent')->attempt($credentials)) {
            // Get the user that was logged in
            $agent = Auth::guard('agent')->user();
            
            // If the user is not approved, return null
            if ($agent->status !== AdminStatus::APPROVED()->value) {
                return null;
            }

            // Return the user and the redirect URL
            return [
                'redirect' => route('agent.dashboard'),
                'agent' => $agent,
            ];
        }

        // If the login failed, return null
        return null;
    }

    /**
     * Logout the user by deleting their tokens.
     *
     * @param  User  $user
     * @return void
     */
    public function agentLogout(): void
    {
        Auth::guard('agent')->logout();
    }
}

