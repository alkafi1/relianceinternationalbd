<?php

namespace App\Services;

use App\Enums\AdminStatus;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserService
{
    public function getAllUsers($search = null, $sortColumn = 'created_at', $sortDirection = 'desc', $filters = [])
    {
        return User::search($search, ['name', 'email'])
            ->filter($filters)
            ->sort($sortColumn, $sortDirection)
            ->paginate(10);
    }

    public function getUserById($id)
    {
        return User::findOrFail($id);
    }

    public function updateUser($id, $data)
    {
        $user = User::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function deleteUser($id)
    {
        return User::destroy($id);
    }

    /**
     * Create a new admin.
     *
     * @param array $validatedData Validated user input
     * @return array|null
     */
    public function store(array $validatedData): ?array
    {
        // Create or find the 'super_admin' role
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Grant all permissions to the 'super_admin' role
        $role->syncPermissions(Permission::where('guard_name', 'web')->get());
        
        // Create the super admin user
        $admin = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'email_verified_at' => now(),    
            'status' => AdminStatus::APPROVED(),
            'password' => Hash::make($validatedData['password']), // Hash the password
            'remember_token' => Str::random(10),
        ]);

        // Assign the 'super_admin' role to the user
        $admin->assignRole($role);

        // Return the admin data
        return [
            'admin' => $admin,
        ];
    }
}
