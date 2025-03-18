<?php

namespace App\Console\Commands;

use Database\Seeders\SeedFromSqlFileSeeder;
use Illuminate\Console\Command;

class SqlSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sql:seed';

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

        // Run each seeder
        $this->callSeeder(SeedFromSqlFileSeeder::class);

        $this->info('Sql seeders completed successfully.');
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
