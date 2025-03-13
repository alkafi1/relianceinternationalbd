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
            'system.index',
            'system.post',
        ];

        foreach ($routes as $route) {
            Permission::create(['name' => $route]);
        }

        $this->command->info('All permissions created successfully.');
    }
}
