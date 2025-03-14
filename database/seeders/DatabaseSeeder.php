<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SeedFromSqlFileSeeder::class,
            PermissionSeeder::class,
            SuperAdminSeeder::class,
            // AgentRolePermissionSeeder::class,
            TerminalSeeder::class,
            // AccountSeeder::class
        ]);
    }
}
