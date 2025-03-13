<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SeedFromSqlFileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // List of SQL files to seed
        $sqlFiles = [
            'divisions.sql',
            'districts.sql',
            'upazilas.sql',
        ];

        // Loop through each SQL file
        foreach ($sqlFiles as $sqlFile) {
            // Path to the SQL file
            $sqlFilePath = database_path('sql/' . $sqlFile);

            // Check if the file exists
            if (!File::exists($sqlFilePath)) {
                $this->command->error("SQL file not found at: {$sqlFilePath}");
                continue; // Skip to the next file
            }

            // Read the SQL file
            $sql = File::get($sqlFilePath);

            // Execute the SQL queries
            DB::unprepared($sql);

            $this->command->info("Data seeded successfully from SQL file: {$sqlFile}");
        }
    }
}
