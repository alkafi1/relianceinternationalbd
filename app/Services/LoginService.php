<?php

namespace App\Services;

use App\Enums\AdminStatus;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginService
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
        if (Auth::attempt($credentials)) {
            // Get the user that was logged in
            $user = Auth::user();
            
            // If the user is not approved, return null
            if ($user->status !== AdminStatus::APPROVED()->value) {
                return null;
            }

            // Return the user and the redirect URL
            return [
                'redirect' => route('dashboard'),
                'user' => $user,
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
    public function logout(User $user): void
    {
        Auth::logout();
    }
}

