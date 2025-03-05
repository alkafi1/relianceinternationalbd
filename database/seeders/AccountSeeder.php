<?php

namespace Database\Seeders;

use App\Enums\AccountTypeEnum;
use App\Models\Account;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the master account data
        $masterAccount = [
            'uid' => Str::uuid(), // Generate a UUID
            'account_holder_uid' => Str::uuid(), // Example account holder UUID (replace with actual party UID)
            'account_holder_type' => User::class,
            'account_name' => 'Master Account', // Name of the master account
            'account_type' => AccountTypeEnum::MASTER(), // Use the MASTER enum value
            'current_balance' => 0.00, // Initial balance
            'created_at' => now(), // Current timestamp
            'updated_at' => now(), // Current timestamp
        ];

        // Insert the master account into the accounts table
        Account::create($masterAccount);

        // Optionally, add more accounts if needed
        $additionalAccounts = [
            [
                'account_holder_uid' => Str::uuid(), // Replace with actual party UID
                'account_name' => 'Savings Account',
                'account_type' => AccountTypeEnum::MASTER(),
                'current_balance' => 1000.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'account_holder_uid' => Str::uuid(), // Replace with actual party UID
                'account_name' => 'Checking Account',
                'account_type' => AccountTypeEnum::MASTER()->value,
                'current_balance' => 500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert additional accounts into the accounts table
        Account::create($additionalAccounts);
    }
}
