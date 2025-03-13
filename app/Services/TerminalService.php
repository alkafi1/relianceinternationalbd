<?php

namespace App\Services;

use App\Models\Jobexpense;
use App\Models\terminal;
use App\Models\TerminalExpense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class  TerminalService
{
    /**
     * Create a new terminal.
     *
     * @param array $validatedData Validated user input
     * @return array|null
     */
    public function store(array $validatedData): ?array
    {
        $terminal = Terminal::create([
            'terminal_name' => $validatedData['terminal_name'],
            'terminal_short_form' => $validatedData['terminal_short_form'],
            'description' => $validatedData['description'],
            'terminal_type' => $validatedData['terminal_type'],
            'status' => $validatedData['status'],
            'address' => $validatedData['address'],
            'created_at' => Carbon::now(),
        ]);

        // Return the terminal data
        return [
            'terminal' => $terminal,
        ];
    }

    public function expenseStore(array $validatedData): ?array
    {
        // Check if a terminal expense record already exists
        $terminalExpense = TerminalExpense::updateOrCreate(
            [
                'terminal_id' => $validatedData['terminal_id'], // Unique identifier
            ],
            [
                'title' => $validatedData['title'],
                'job_type' => $validatedData['job_type'],
                'comission_rate' => $validatedData['comission_rate'],
                'minimum_comission' => $validatedData['minimum_comission'],
                'status' => $validatedData['status'],
            ]
        );

        // Create or update the job expense records
        $this->jobExpenseStore($terminalExpense->uid, $validatedData);

        // Return the terminal data
        return [
            'terminalExpense' => $terminalExpense,
        ];
    }

    public function jobExpenseStore($terminalExpenseId, $validatedData)
    {
        // Loop through the job expenditure fieldss
        
        foreach ($validatedData['job_expend_field'] as $index => $field) {
            // Check if a job expense record already exists
            JobExpense::updateOrCreate(
                [
                    'terminal_expense_id' => $terminalExpenseId, // Unique identifier
                    'job_expend_field' => $field,               // Unique identifier
                ],
                [
                    'terminal_id' => $validatedData['terminal_id'],
                    'amount' => $validatedData['amount'][$index],
                    'status' => $validatedData['status'],
                ]
            );
        }
    }
}
