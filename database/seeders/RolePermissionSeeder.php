<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get roles and permissions from config
        $rolesPermissions = config('roles_permissions.roles');
        
        foreach ($rolesPermissions as $roleName => $roleData) {
            // Create the role
            $role = Role::firstOrCreate(['name' => $roleName]);
            
            // Handle wildcard permissions for super_admin
            if ($roleName === 'super_admin') {
                // Grant all permissions to super_admin
                $role->givePermissionTo(Permission::all());
                continue;
            }

            // Loop through permissions for the role
            foreach ($roleData['permissions'] as $resource => $actions) {
                foreach ($actions as $action) {
                    // Create permission name (e.g., "create posts")
                    $permissionName = "$action $resource";

                    // Create or find the permission
                    $permission = Permission::firstOrCreate(['name' => $permissionName]);

                    // Assign the permission to the role
                    $role->givePermissionTo($permission);
                }
            }
        }
    }
}
