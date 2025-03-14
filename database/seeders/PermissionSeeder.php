<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define permissions based on route names
        $routes = [
            'dashboard',
            'agent.dashboard',
            'admin.index',
            'admin.create',
            'admin.store',
            'admin.edit',
            'admin.update',
            'admin.destroy',
            'admin.status.update',
            'admin.status',
            'agent.index',
            'agent.create',
            'agent.store',
            'agent.edit',
            'agent.update',
            'agent.destroy',
            'agent.status.update',
            'agent.status',
            'terminal.index',
            'terminal.create',
            'terminal.store',
            'terminal.edit',
            'terminal.update',
            'terminal.destroy',
            'terminal.status',
            'party.index',
            'party.create',
            'party.store',
            'party.edit',
            'party.update',
            'party.destroy',
            'party.status.update',
            'party.status',
            'job.index',
            'job.create',
            'job.store',
            'job.edit',
            'job.update',
            'job.destroy',
            'job.status.update',
            'job.status',
            // 'job.datatable',
            'role.index',
            'role.create',
            'role.store',
            'role.edit',
            'role.update',
            'role.destroy',
            'system.index',
            'system.post',
        ];

        // Create permissions for the 'web' guard (default)
        foreach ($routes as $route) {
            Permission::firstOrCreate([
                'name' => $route,
                'guard_name' => 'web', // Specify the guard name
            ]);
        }

        // Create permissions for the 'agent' guard
        foreach ($routes as $route) {
            Permission::firstOrCreate([
                'name' => $route,
                'guard_name' => 'agent', // Specify the guard name
            ]);
        }

        $this->command->info('All permissions created successfully.');
    }
}
