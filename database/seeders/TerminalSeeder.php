<?php

namespace Database\Seeders;

use App\Enums\TerminalStatusEnum;
use App\Enums\TerminalTypeEnum;
use App\Models\Jobexpense;
use App\Models\Terminal;
use App\Models\TerminalExpense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TerminalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the terminals data
        $terminals = [
            [
                'terminal_name' => 'Dhaka Airport',
                'terminal_short_form' => 'AIR',
                'description' => 'The prime airport in Bangladesh',
                'terminal_type' => TerminalTypeEnum::BOTH()->value,
                'address' => 'Dhaka uttara',
                'status' => TerminalStatusEnum::ACTIVE()->value,
            ],
            [
                'terminal_name' => 'Chattogram Port',
                'terminal_short_form' => 'CTG',
                'description' => '',
                'terminal_type' => TerminalTypeEnum::BOTH()->value,
                'address' => 'Chattogram Port',
                'status' => TerminalStatusEnum::ACTIVE()->value,
            ],
            [
                'terminal_name' => 'Benapole',
                'terminal_short_form' => 'BNP',
                'description' => '',
                'terminal_type' => TerminalTypeEnum::BOTH()->value,
                'address' => 'Benapole',
                'status' => TerminalStatusEnum::ACTIVE()->value,
            ],
            [
                'terminal_name' => 'ADAMJEE EPZ',
                'terminal_short_form' => 'AEPZ',
                'description' => '',
                'terminal_type' => TerminalTypeEnum::EXPORT()->value,
                'address' => 'narayanganj',
                'status' => TerminalStatusEnum::ACTIVE()->value,
            ],
            [
                'terminal_name' => 'Pangong',
                'terminal_short_form' => 'P.GONG',
                'description' => '',
                'terminal_type' => TerminalTypeEnum::BOTH()->value,
                'address' => 'Pangong',
                'status' => TerminalStatusEnum::ACTIVE()->value,
            ],
            [
                'terminal_name' => 'DEPZ',
                'terminal_short_form' => 'DEPZ',
                'description' => '',
                'terminal_type' => TerminalTypeEnum::BOTH()->value,
                'address' => 'Savar',
                'status' => TerminalStatusEnum::ACTIVE()->value,
            ],
            [
                'terminal_name' => 'DHAKA AIRPORT SAMPLE',
                'terminal_short_form' => 'AIR',
                'description' => '',
                'terminal_type' => TerminalTypeEnum::EXPORT()->value,
                'address' => 'AIRPORT',
                'status' => TerminalStatusEnum::ACTIVE()->value,
            ],
            [
                'terminal_name' => 'CUMILLA EPZ',
                'terminal_short_form' => 'CEPZ(CUMILLA)',
                'description' => '',
                'terminal_type' => TerminalTypeEnum::BOTH()->value,
                'address' => 'CUMILLA',
                'status' => TerminalStatusEnum::ACTIVE()->value,
            ],
            [
                'terminal_name' => 'Chattogram CEPZ',
                'terminal_short_form' => 'CTG (CEPZ)',
                'description' => '',
                'terminal_type' => TerminalTypeEnum::EXPORT()->value,
                'address' => 'Chattogram',
                'status' => TerminalStatusEnum::ACTIVE()->value,
            ],
            [
                'terminal_name' => 'QUASEM INDUSTRIES/DHAKA AIRPORT SAMPLE/AIRPORT',
                'terminal_short_form' => 'AIR',
                'description' => '',
                'terminal_type' => TerminalTypeEnum::BOTH()->value,
                'address' => 'AIRPORT',
                'status' => TerminalStatusEnum::ACTIVE()->value,
            ],
            [
                'terminal_name' => 'ICD (KAMLAPUR)',
                'terminal_short_form' => 'ICD',
                'description' => '',
                'terminal_type' => TerminalTypeEnum::BOTH()->value,
                'address' => 'CUSTOMS HOUSE, ICD',
                'status' => TerminalStatusEnum::ACTIVE()->value,
            ],
            [
                'terminal_name' => 'DEPZ EXPORT',
                'terminal_short_form' => 'DEPZ',
                'description' => '',
                'terminal_type' => TerminalTypeEnum::IMPORT()->value,
                'address' => 'Savar, EPZ',
                'status' => TerminalStatusEnum::DEACTIVE()->value,
            ],
        ];

        $expenseFields = [
            [
                'expense_name' => 'Dhaka Airport Import Fields',
                'terminal_id' => 1,
                'job_type' => 2, // Import
                'job_expenses' => [
                    ['title' => 'ASSOCIATION FEE + data entry = 80/- + 40/-', 'amount' => 120.00],
                    ['title' => 'DUTY/VAT PAID', 'amount' => 0.00],
                    ['title' => 'WHARF RENT', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR DELIVERY WITHOUT L/C BY SAMPLE PASS BOOK', 'amount' => 0.00],
                    ['title' => 'EXTRA EXP. FOR AWB NO.CORRECTION BY BIMAN (AS DISCUSS WITH MR. ASAD)', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES DUE TO MIS-DECLARATION  DELIVERY POSITION GATE', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR GOODS FIND OUT', 'amount' => 0.00],
                    ['title' => 'NOC CHARGE', 'amount' => 5500.00],
                    ['title' => 'DELIVERY FROM RUNWAY (LABOUR CHARGE)           (  00/- X 00   CTNS/ROLLS ) IN & OUT', 'amount' => 0.00],
                    ['title' => 'HANDLING EXPENSES FOR CUSTOMS', 'amount' => 2100.00],
                ],
                'comission_rate' => 0.09,
                'minimum_comission' => 1000.00,
            ],
            [
                'expense_name' => 'Dhaka Airport Export Fields',
                'terminal_id' => 1,
                'job_type' => 1, // Export
                'job_expenses' => [
                    ['title' => 'ASSOCIATION     80/-', 'amount' => 80.00],
                    ['title' => 'DUTY/VAT PAID WITH SCANNING CHARGES', 'amount' => 110.00],
                    ['title' => 'DOCUMENT PROCESSING EXPENSES    200/-', 'amount' => 200.00],
                    ['title' => 'PASS BOOK ENTRY   200/-', 'amount' => 200.00],
                    ['title' => 'AMENDMENT CHARGE    200/-', 'amount' => 0.00],
                    ['title' => 'tr challan purpose', 'amount' => 0.00],
                    ['title' => 'HANDLING AND OTHER EXPENSES', 'amount' => 800.00],
                ],
                'comission_rate' => 0.07,
                'minimum_comission' => 800.00,
            ],
            [
                'expense_name' => 'CTG Export Fields',
                'terminal_id' => 2,
                'job_type' => 1, // Export
                'job_expenses' => [
                    ['title' => 'ASSOCIATION  FEE', 'amount' => 85.00],
                    ['title' => 'DUTY/VAT PAID WITH SCANNING CHARGES', 'amount' => 342.00],
                    ['title' => 'DOCUMENT PROCESSING EXPENSES', 'amount' => 200.00],
                    ['title' => 'PASS BOOK ENTRY  @ 200/-', 'amount' => 200.00],
                    ['title' => 'EXTRA EXP.DUE TO  AMENDMENT @ 300/-', 'amount' => 0.00],
                    ['title' => 'T/R CHALLAN (PAID ONLINE)                (  50/- )', 'amount' => 0.00],
                    ['title' => 'LABOR CHARGE FOR UNLOADING/LANDING + SORTING               (/- + /-)', 'amount' => 0.00],
                    ['title' => 'HANDLING AND OTHER EXPENSES', 'amount' => 800.00],
                ],
                'comission_rate' => 0.07,
                'minimum_comission' => 800.00,
            ],
            [
                'expense_name' => 'CTG Import Fields',
                'terminal_id' => 2,
                'job_type' => 2, // Import
                'job_expenses' => [
                    ['title' => 'ASSOCIATION  FEE', 'amount' => 70.00],
                    ['title' => 'DUTY/VAT PAID WITH SCANNING CHARGES', 'amount' => 0.00],
                    ['title' => 'EXTRA  EXPENSES FOR  NILL-MARK PURPOSE', 'amount' => 0.00],
                    ['title' => 'B/L VERIFY WITH VAT', 'amount' => 345.00],
                    ['title' => 'SHIPPING AGENT CHARGES WITH P/O', 'amount' => 0.00],
                    ['title' => 'PORT CHARGES', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSE FOR RED CUTTING FILE PURPOSE', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR AVOID EXAM. TTL YDS. 62700.00 YDS', 'amount' => 0.00],
                    ['title' => 'LABOR WITH SAMPLE YDS', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR 100% EXAM. (IMPORT FM PAKISTAN )', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR UNLOADING LABOR PURPOSE OVER LOADING  00 KGS./TIPS', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR PART PERMISSION PURPOSE', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR CONTAINER KEEP DOWN TWO TIME   (100/- X 00)', 'amount' => 0.00],
                    ['title' => 'DELIVERY HANDLING EXPENSES     COVER VAN/LOCAL TRUCK  (800/ X 00)', 'amount' => 0.00],
                    ['title' => 'HANDLING EXPENSES FOR CUSTOMS         (FCL X 40\'(PART) X 01)', 'amount' => 3200.00],
                    ['title' => 'HANDLING EXPENSES FOR CUSTOMS         (FCL X 20\' X 01)', 'amount' => 2800.00],
                    ['title' => 'HANDLING EXPENSES FOR CUSTOMS         (LCL)', 'amount' => 1900.00],
                ],
                'comission_rate' => 0.09,
                'minimum_comission' => 1000.00,
            ],
            [
                'expense_name' => 'DEPZ Import Fields',
                'terminal_id' => 6,
                'job_type' => 2, // Import
                'job_expenses' => [
                    ['title' => 'ASSOCIATION FEE', 'amount' => 230.00],
                    ['title' => 'DUTY/VAT PAID', 'amount' => 0.00],
                    ['title' => 'PART DELIVERY            (    part x 800/-  )', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR LABOR            (   roll/ctn x 13/-  )', 'amount' => 0.00],
                    ['title' => 'L/C VERIFY PURPOSE', 'amount' => 0.00],
                    ['title' => 'HANDLING EXPENSES', 'amount' => 2100.00],
                ],
                'comission_rate' => 0.09,
                'minimum_comission' => 1000.00,
            ],
            [
                'expense_name' => 'Dhaka Airport (Sample)',
                'terminal_id' => 7,
                'job_type' => 2, // Import
                'job_expenses' => [
                    ['title' => 'ASSOCIATION FEE + DATA ENTRY = 80/- + 40/-', 'amount' => 120.00],
                    ['title' => 'DUTY/VAT PAID', 'amount' => 110.00],
                    ['title' => 'WHARF RENT', 'amount' => 166.00],
                    ['title' => 'LABOUR CHARGE           (  30/- X 01  CTNS ) IN & OUT', 'amount' => 30.00],
                    ['title' => 'EXTRA EXPENSE FOR EXAMIN PURPOSE', 'amount' => 500.00],
                    ['title' => 'EXTRA EXPENSES FOR RED CUTTING PK', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR EXAMINATION OF PAKISTAN CONSIGNMENT', 'amount' => 0.00],
                ],
                'comission_rate' => 0.00,
                'minimum_comission' => 1100.00,
            ],
            [
                'expense_name' => 'CHITTAGONG CEPZ',
                'terminal_id' => 9,
                'job_type' => 2, // Import
                'job_expenses' => [
                    ['title' => 'ASSOCIATION FEE', 'amount' => 70.00],
                    ['title' => 'DUTY/VAT PAID', 'amount' => 0.00],
                    ['title' => 'PART DELIVERY                 ( 00   x   800/-)', 'amount' => 0.00],
                    ['title' => 'CTG CUSTOMS HOUSE IGM PREPARED PURPOSE CEPZ WORK', 'amount' => 1500.00],
                    ['title' => 'EXTRA EXPENSES FOR LABOR                     ( 00 X 13/-)', 'amount' => 0.00],
                    ['title' => 'DELIVERY EXPENSE PER TRUCK / COVER VAN', 'amount' => 700.00],
                    ['title' => 'HANDLING EXPENSES CEPZ CUSTOMS', 'amount' => 2100.00],
                ],
                'comission_rate' => 0.09,
                'minimum_comission' => 1000.00,
            ],
            [
                'expense_name' => 'ADAMJEE EPZ',
                'terminal_id' => 4,
                'job_type' => 2, // Import
                'job_expenses' => [
                    ['title' => 'ASSOCIATION FEE', 'amount' => 230.00],
                    ['title' => 'DUTY/VAT PAID', 'amount' => 0.00],
                    ['title' => 'PART DELIVERY                 ( 01   x   800/-)', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR LABOR       (     ctn/roll  x 13/-)', 'amount' => 0.00],
                    ['title' => 'HANDLING EXPENSES', 'amount' => 2100.00],
                ],
                'comission_rate' => 0.09,
                'minimum_comission' => 1000.00,
            ],
            [
                'expense_name' => 'Comilla CEPZ IMPORT',
                'terminal_id' => 8,
                'job_type' => 2, // Import
                'job_expenses' => [
                    ['title' => 'ASSOCIATION FEE + data entry    (80/- + 50/-)', 'amount' => 130.00],
                    ['title' => 'DUTY/VAT PAID', 'amount' => 0.00],
                    ['title' => 'PART DELIVERY    (  0   X 800/- )', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR LABOR    ( 0 X 13/-)', 'amount' => 0.00],
                    ['title' => 'L/C VERIFY PURPOSE', 'amount' => 0.00],
                    ['title' => 'HANDLING EXPENSES', 'amount' => 2100.00],
                ],
                'comission_rate' => 0.09,
                'minimum_comission' => 1000.00,
            ],
            [
                'expense_name' => 'Benapole Import',
                'terminal_id' => 3,
                'job_type' => 2, // Import
                'job_expenses' => [
                    ['title' => 'ASSOCIATION FEE', 'amount' => 500.00],
                    ['title' => 'DUTY/VAT PAID', 'amount' => 0.00],
                    ['title' => 'WARE HOUSE CHARGE', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSES FOR LABOR CHARGE (IN & OUT) PER ROLL @ TK. 40 + TK. 40 ( 00 ROLL X 80/- )', 'amount' => 0.00],
                    ['title' => 'HANDLING EXPENSES', 'amount' => 3000.00],
                ],
                'comission_rate' => 0.09,
                'minimum_comission' => 1000.00,
            ],
            [
                'expense_name' => 'BENAPOLE EXPORT',
                'terminal_id' => 3,
                'job_type' => 1, // Export
                'job_expenses' => [
                    ['title' => 'ASSOCIATION FEE +DATA ENTRY = 180/- + 100/-', 'amount' => 0.00],
                    ['title' => 'DUTY/VAT PAID', 'amount' => 0.00],
                    ['title' => 'PASS BOOK ENTRY', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSE FOR AMENDMENT', 'amount' => 0.00],
                    ['title' => 'HANDLING EXPENSES', 'amount' => 0.00],
                ],
                'comission_rate' => 0.08,
                'minimum_comission' => 1000.00,
            ],
            [
                'expense_name' => 'QUASEM INDUSTRIES',
                'terminal_id' => 10,
                'job_type' => 2, // Import
                'job_expenses' => [
                    ['title' => 'ASSOCIATION FEE +DATA ENTRY+ COURT FEE = 40/- + 50/- + 25/-', 'amount' => 0.00],
                    ['title' => 'DUTY/VAT PAID', 'amount' => 0.00],
                    ['title' => 'WHARF RENT', 'amount' => 0.00],
                    ['title' => 'NOC CHARGE/ AIR WAY BILL RECEIVED FM', 'amount' => 0.00],
                    ['title' => 'TRANSPORTATION (PICK-UP/CNG)', 'amount' => 0.00],
                    ['title' => 'PHOTOCOPY + DOCUMENTATION', 'amount' => 0.00],
                    ['title' => 'CUSTOMS EXAMINE (UP TO A/C + GATE PREVENTIVE)', 'amount' => 0.00],
                    ['title' => 'CUSTOMS ASSESSMENT EXPENSES (UP TO DC)', 'amount' => 0.00],
                    ['title' => 'DELIVERY WITHOUT COUNTRY OF ORIGIN', 'amount' => 0.00],
                    ['title' => 'BIMAN GATE PASS', 'amount' => 0.00],
                    ['title' => 'NOTING', 'amount' => 0.00],
                    ['title' => 'BANK PAY ORDER AND COMMISSION PURPOSE', 'amount' => 0.00],
                    ['title' => 'LOADER', 'amount' => 0.00],
                    ['title' => 'EXTRA EXPENSE FOR AVOID CHEMICAL TEST', 'amount' => 0.00],
                    ['title' => 'HANDLING EXPENSE/DELIVERY EXPENSE', 'amount' => 0.00],
                ],
                'comission_rate' => 0.10,
                'minimum_comission' => 2000.00,
            ],
            [
                'expense_name' => 'KAMLAPUR ICD',
                'terminal_id' => 11,
                'job_type' => 1, // Export
                'job_expenses' => [
                    ['title' => 'ASSOCIATION FEE', 'amount' => 0.00],
                    ['title' => 'DUTY/VAT PAID WITH SCANNING CHARGES', 'amount' => 0.00],
                    ['title' => 'PASS BOOK ENTRY', 'amount' => 0.00],
                    ['title' => 'LABOR CHARGE FOR UNLOADING/LANDING + SORTING               (/- + /-)', 'amount' => 0.00],
                    ['title' => 'HANDLING AND OTHER EXPENSES', 'amount' => 800.00],
                ],
                'comission_rate' => 0.07,
                'minimum_comission' => 800.00,
            ],
        ];

        // Insert the data into the terminals table
        // foreach ($terminals as $terminal) {
        //     $terminal = Terminal::create($terminal);
        // }

        // Insert the data into the terminals, terminal_expenses, and job_expenses tables
        foreach ($terminals as $terminalData) {
            // Create the terminal
            $terminal = Terminal::create([
                'terminal_name' => $terminalData['terminal_name'],
                'terminal_short_form' => $terminalData['terminal_short_form'],
                'description' => $terminalData['description'],
                'terminal_type' => $terminalData['terminal_type'],
                'address' => $terminalData['address'],
                'status' => $terminalData['status'],
            ]);

            // Create the expense fields for the terminal
            foreach ($expenseFields as $expenseField) {
                $terminalExpense = TerminalExpense::create([
                    'terminal_id' => $terminal->uid,
                    'title' => $expenseField['expense_name'],
                    'job_type' => $expenseField['job_type'],
                    'comission_rate' => $expenseField['comission_rate'],
                    'minimum_comission' => $expenseField['minimum_comission'],
                    'status' => $terminal['status'],
                ]);
                // dd($expenseField['job_expenses']);

                // Create the job expenses for the terminal expense
                foreach ($expenseField['job_expenses'] as $jobExpense) {
                    Jobexpense::create([
                        'terminal_expense_id' => $terminalExpense->uid,
                        'job_expend_field' => $jobExpense['title'],
                        'terminal_id' => $terminal->uid,
                        'amount' => $jobExpense['amount'],
                        'status' => $terminal['status'],
                    ]);
                }
            }
        }

        $this->command->info('Main Terminal created successfully.');
    }
}
