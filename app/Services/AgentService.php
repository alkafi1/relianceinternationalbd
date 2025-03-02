<?php

namespace App\Services;

use App\Enums\AdminStatus;
use App\Models\Agent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AgentService
{
    /**
     * Create a new agent.
     *
     * @param array $validatedData Validated user input
     * @return array|null
     */
    public function store(array $validatedData): ?array
    {
        // Handle the image upload
        // if ($validatedData['image']) {
        //     $image = $validatedData['image'];
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     $image->move(public_path('images'), $imageName);
        //     $validatedData['image'] = $imageName;
        // }

        // Create the agent
        $agent = Agent::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'age' => $validatedData['age'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => Hash::make($validatedData['password']), // Hash the password
            'address' => $validatedData['address'],
            'division_id' => $validatedData['division_id'],
            'district_id' => $validatedData['district_id'],
            'thana_id' => $validatedData['thana_id'],
            'status' => $validatedData['status'],
            // 'image' => $imagePath, // Store the image path
        ]);

        // Return the agent data
        return [
            'agent' => $agent,
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

