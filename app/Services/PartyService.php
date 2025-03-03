<?php

namespace App\Services;

use App\Enums\AdminStatus;
use App\Models\Agent;
use App\Models\Party;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PartyService
{
    /**
     * Create a new agent.
     *
     * @param array $validatedData Validated user input
     * @return array|null
     */
    public function store(array $validatedData): ?array
    {
        // Create the party
        $party = Party::create([
            'party_name' => $validatedData['party_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'address' => $validatedData['address'],
            'status' => $validatedData['status'],
        ]);

        // Return the agent data
        return [
            'party' => $party,
        ];
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
