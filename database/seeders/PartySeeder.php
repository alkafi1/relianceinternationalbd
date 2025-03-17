<?php

namespace Database\Seeders;

use App\Enums\AccountTypeEnum;
use App\Enums\PartyStatusEnum;
use App\Models\Account;
use App\Models\Party;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the members data
        $members = [
            [
                'party_name' => 'PIMKIE APPARELS LTD',
                'email' => 'pimkiebd@gmail.com',
                'phone' => '0123456825',
                'address' => 'SENA KALYAN COMMERCIAL COMPLEX TONGI, GAZIPUR',
                'status' => PartyStatusEnum::APPROVED()->value,
            ],
            [
                'party_name' => 'ABA GARMENTS LIMITED',
                'email' => 'abagarmentslimited@gmail.com',
                'phone' => null,
                'address' => 'SENA KALYAN COMMERCIAL COMPLEX TONGI, GAZIPUR',
                'status' => PartyStatusEnum::DELETED()->value,
            ],
            [
                'party_name' => 'ABA FASHION LIMITED',
                'email' => 'abafashionlimited@gmail.com',
                'phone' => null,
                'address' => 'SENA KALYAN COMMERCIAL COMPLEX TONGI, GAZIPUR',
                'status' => PartyStatusEnum::APPROVED()->value,
            ],
            [
                'party_name' => 'QUASEM INDUSTRIES LTD',
                'email' => 'quasemindustries@gmail.com',
                'phone' => '+88-02-9820649-52, Ext. 180',
                'address' => '32, KAMAL ATATURK, AVENUE BANANI, DHAKA',
                'status' => PartyStatusEnum::APPROVED()->value,
            ],
            [
                'party_name' => 'QUASEM DRYCELL LTD',
                'email' => 'quasemdrycell@gmail.com',
                'phone' => null,
                'address' => '32, KAMAL ATATURK, AVENUE BANANI, DHAKA',
                'status' => PartyStatusEnum::APPROVED()->value,
            ],
            [
                'party_name' => 'QUASEM FOOD LTD',
                'email' => 'quasemfood@gmail.com',
                'phone' => null,
                'address' => '32, KAMAL ATATURK, AVENUE BANANI, DHAKA',
                'status' => PartyStatusEnum::APPROVED()->value,
            ],
            [
                'party_name' => 'A. D. TRADE',
                'email' => 'adtrade@gmail.com',
                'phone' => null,
                'address' => 'KALMA-1, DAIRY FIRM, SAVAR, DHAKA',
                'status' => PartyStatusEnum::APPROVED()->value,
            ],
            [
                'party_name' => 'MARS AIR & SEA FREIGHT',
                'email' => 'marsairandseafreight@gmail.com',
                'phone' => null,
                'address' => 'HOUSE- 441, ROAD- 30, NEW DOHS, MOHAKHALI, DHAKA-1206.',
                'status' => PartyStatusEnum::APPROVED()->value,
            ],
            [
                'party_name' => 'YOUNG LABELS LTD',
                'email' => 'younglabels@gmail.com',
                'phone' => null,
                'address' => 'Sreepur, Ashulia, Savar',
                'status' => PartyStatusEnum::APPROVED()->value,
            ],
            [
                'party_name' => 'YOUNG SOCKS LTD',
                'email' => 'youngsocks@gmail.com',
                'phone' => null,
                'address' => 'Sreepur, Ashulia, Savar',
                'status' => PartyStatusEnum::APPROVED()->value,
            ],
            [
                'party_name' => 'VINTAGE DENIM LTD.',
                'email' => 'vintagedenim@gmail.com',
                'phone' => null,
                'address' => 'SENA KALYAN COMMERCIAL COMPLEX TONGI, GAZIPUR',
                'status' => PartyStatusEnum::APPROVED()->value,
            ],
            [
                'party_name' => 'ABA GARMENTS',
                'email' => 'abagarments@gmail.com',
                'phone' => null,
                'address' => 'SENA KALYAN COMMERCIAL COMPLEX TONGI, GAZIPUR',
                'status' => PartyStatusEnum::DELETED()->value,
            ],
        ];

        // Insert the data into the parties table
        foreach ($members as $member) {
            $party = Party::create([
                'party_name' => $member['party_name'],
                'email' => $member['email'],
                'phone' => $member['phone'],
                'address' => $member['address'],
                'status' => $member['status'],
            ]);

            // Create the account for the party
            $this->createAccount($party, $member);
        }

        // Insert the data into the agents table
        $this->command->info('Parties created successfully.');
    }
    protected function createAccount($party, $data)
    {
        // Example: Create an account for the party
        $account = Account::create([
            'account_holder_uid' => $party->uid,
            'account_holder_type' => Party::class,
            'account_name' => $data['party_name'],
            'account_type' => AccountTypeEnum::PARTY()->value,
        ]);
    }
}
