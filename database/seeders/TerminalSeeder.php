<?php

namespace Database\Seeders;

use App\Enums\TerminalStatusEnum;
use App\Enums\TerminalTypeEnum;
use App\Models\Terminal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TerminalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Creating a new terminal instance
        $terminal = Terminal::create([
            'uid' => (string) Str::uuid(), // Generate a new UUID
            'terminal_id' => 'T123',
            'terminal_name' => 'Main Terminal',
            'terminal_short_form' => 'MT',
            'description' => 'Main terminal for operations',
            'terminal_type' => TerminalTypeEnum::BOTH()->value, // 1 = Both
            'address' => '123 Terminal St.',
            'status' => TerminalStatusEnum::ACTIVE()->value, // 1 = Active
        ]);

        $this->command->info('Main Terminal created successfully.');
    }
}
