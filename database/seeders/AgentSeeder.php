<?php

namespace Database\Seeders;

use App\Enums\AgentStatus;
use App\Models\Agent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the agents data
        $agents = [
            [
                'uid' => Str::uuid()->toString(),
                'first_name' => 'S. M. Jahedul',
                'last_name' => 'Islam Juwel',
                'age' => 28,
                'email' => 'juwels29@gmail.com',
                'phone' => '01521212629',
                'password' => Hash::make('123456'), // Default password
                'address' => 'House-38, Road-08',
                'division_id' => 3,
                'district_id' => 1,
                'thana_id' => 496,
                'status' => AgentStatus::APPROVED()->value,
            ],
            [
                'uid' => Str::uuid()->toString(),
                'first_name' => 'MD. Tariqul',
                'last_name' => 'Islam Tareq',
                'age' => 33,
                'email' => 'tareq@gmail.com',
                'phone' => '01687903040',
                'password' => Hash::make('123456'), // Default password
                'address' => 'House-2449, Askona, Uttra, Dhaka-1230.',
                'division_id' => 6,
                'district_id' => 27,
                'thana_id' => 410,
                'status' => AgentStatus::APPROVED()->value,
            ],
            [
                'uid' => Str::uuid()->toString(),
                'first_name' => 'Md. Majedul',
                'last_name' => 'Islam',
                'age' => 28,
                'email' => 'majed@gmail.com',
                'phone' => '01720288774',
                'password' => Hash::make('123456'), // Default password
                'address' => 'House-271, Aamtola Dhokhin Khan, Dhaka',
                'division_id' => 5,
                'district_id' => 18,
                'thana_id' => 338,
                'status' => AgentStatus::APPROVED()->value,
            ],
            [
                'uid' => Str::uuid()->toString(),
                'first_name' => 'Md. Kamrul',
                'last_name' => 'Hasan',
                'age' => 21,
                'email' => 'talhaahamed102@gmail.com',
                'phone' => '01777658473',
                'password' => Hash::make('123456'), // Default password
                'address' => 'House-.... Askona, Dhakhin Khan, Dhaka',
                'division_id' => 3,
                'district_id' => 9,
                'thana_id' => 205,
                'status' => AgentStatus::APPROVED()->value,
            ],
            [
                'uid' => Str::uuid()->toString(),
                'first_name' => 'All Chattogram',
                'last_name' => 'Staff',
                'age' => 35,
                'email' => 'ctg.job@gmail.com',
                'phone' => '01745372079',
                'password' => Hash::make('123456'), // Default password
                'address' => 'Agrabad, chittagong',
                'division_id' => 2,
                'district_id' => 43,
                'thana_id' => 73,
                'status' => AgentStatus::APPROVED()->value,
            ],
            [
                'uid' => Str::uuid()->toString(),
                'first_name' => 'Md. Hasan',
                'last_name' => 'Reza',
                'age' => 33,
                'email' => 'shanto@gmail.com',
                'phone' => '01703178323',
                'password' => Hash::make('123456'), // Default password
                'address' => '136, Bangshal road, Dhaka-1100',
                'division_id' => 3,
                'district_id' => 9,
                'thana_id' => 205,
                'status' => AgentStatus::APPROVED()->value,
            ],
            [
                'uid' => Str::uuid()->toString(),
                'first_name' => 'Md. Humayun',
                'last_name' => 'Kabir',
                'age' => 38,
                'email' => 'mintu@gmail.com',
                'phone' => '01670025097',
                'password' => Hash::make('123456'), // Default password
                'address' => '',
                'division_id' => 3,
                'district_id' => 1,
                'thana_id' => 532,
                'status' => AgentStatus::APPROVED()->value,
            ],
            [
                'uid' => Str::uuid()->toString(),
                'first_name' => 'Md. Biplob',
                'last_name' => 'Rahman',
                'age' => 25,
                'email' => 'biplob@gmail.com',
                'phone' => '01760884908',
                'password' => Hash::make('123456'), // Default password
                'address' => '',
                'division_id' => 3,
                'district_id' => 1,
                'thana_id' => 526,
                'status' => AgentStatus::APPROVED()->value,
            ],
            [
                'uid' => Str::uuid()->toString(),
                'first_name' => 'Md. Rony',
                'last_name' => 'Babu',
                'age' => 21,
                'email' => 'rony@gmail.com',
                'phone' => '01786752996',
                'password' => Hash::make('123456'), // Default password
                'address' => 'Prembagan, Askona, Airport, Dhaka',
                'division_id' => 6,
                'district_id' => 27,
                'thana_id' => 410,
                'status' => AgentStatus::APPROVED()->value,
            ],
        ];

        // Insert the data into the agents table
        foreach ($agents as $agent) {
            $agent = Agent::create($agent);
            $agent->assignRole('agent');
        }

        $this->command->info('Agents created successfully.');
    }
}
