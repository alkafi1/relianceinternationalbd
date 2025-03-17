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
            AgentRolePermissionSeeder::class,
            SuperAdminSeeder::class,
            // AccountSeeder::class,
            AgentSeeder::class,
            PartySeeder::class,
            TerminalSeeder::class,
        ]);
    }
}
