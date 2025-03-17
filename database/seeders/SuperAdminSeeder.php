<?php

namespace Database\Seeders;

use App\Enums\AdminStatus;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or find the 'super_admin' role
        $superAdminRole = Role::firstOrCreate(['name' => 'super-admin', 'guard_name' => 'web']);

        // Grant all permissions to the 'super_admin' role
        $superAdminRole->syncPermissions(Permission::where('guard_name', 'web')->get());

        // Create the super admin user
        $user = User::create([
            'uid' => Str::uuid()->toString(), // Generate UUID
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@gmail.com',
            'email_verified_at' => now(),
            'status' => AdminStatus::APPROVED(),
            'password' => Hash::make('password'), // Hash the password
            'remember_token' => Str::random(10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // Assign the 'super_admin' role to the user
        $user->assignRole($superAdminRole);

        $this->command->info('Super Admin created successfully.');
    }
}
