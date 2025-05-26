<?php

namespace App\Console\Commands;

use Database\Seeders\AgentRolePermissionSeeder;
use Database\Seeders\AgentSeeder;
use Database\Seeders\PartySeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\SeedFromSqlFileSeeder;
use Database\Seeders\SuperAdminSeeder;
use Database\Seeders\TerminalSeeder;
use Illuminate\Console\Command;

class SeedAllCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all seeders in a single command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Running all seeders...');

        $this->callSeeder(PermissionSeeder::class);
        $this->callSeeder(AgentRolePermissionSeeder::class);
        $this->callSeeder(SuperAdminSeeder::class);
        $this->callSeeder(AgentSeeder::class);
        $this->callSeeder(PartySeeder::class);
        $this->callSeeder(TerminalSeeder::class);

        $this->info('All seeders completed successfully.');
    }

    /**
     * Helper method to run a seeder.
     *
     * @param string $seederClass
     */
    protected function callSeeder(string $seederClass)
    {
        $this->info("Running {$seederClass}...");
        $this->call('db:seed', ['--class' => $seederClass]);
        $this->info("{$seederClass} completed.");
    }
}
