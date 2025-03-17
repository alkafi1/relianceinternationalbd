<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AgentRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'agent','guard_name' => 'agent']);

        $routes = [
            'agent.dashboard',
            'job.index',
            'job.create',
            'job.store',
        ];
        // foreach ($routes as $route) {
        //     $permission = Permission::firstOrCreate([
        //         'name' => $route,
        //         'guard_name' => 'agent',
        //     ]);
        // }
        $role->givePermissionTo($routes);

        $this->command->info('Agent role and permission created successfully.');
    }
}
