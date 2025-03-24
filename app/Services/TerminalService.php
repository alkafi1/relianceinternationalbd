<?php

namespace App\Services;

use App\Models\Jobexpense;
use App\Models\terminal;
use App\Models\TerminalExpense;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // Use a database transaction to ensure data integrity
        $terminalExpense = DB::transaction(function () use ($validatedData) {
            // Check if a terminal expense record already exists, if not, create it
            $terminalExpense = TerminalExpense::create([
                'terminal_id' => $validatedData['terminal_id'],
                'title' => $validatedData['title'],
                'job_type' => $validatedData['job_type'],
                'comission_rate' => $validatedData['comission_rate'],
                'minimum_comission' => $validatedData['minimum_comission'],
                'status' => $validatedData['status'],
            ]);

            // Create or update the job expense records associated with the terminal expense
            $this->storeJobExpenses($terminalExpense->uid, $validatedData);

            return $terminalExpense;
        });

        // Return the terminal expense data
        return [
            'terminalExpense' => $terminalExpense,
        ];
    }

    /**
     * Store or update job expenses associated with a terminal expense.
     *
     * @param int $terminalExpenseId
     * @param array $validatedData
     */
    protected function storeJobExpenses($terminalExpenseId, array $validatedData): void
    {
        // Loop through the job expenditure fields
        foreach ($validatedData['job_expend_field'] as $index => $field) {
            // Check if a job expense record already exists, if not, create it
            JobExpense::create(
                [
                    'terminal_expense_id' => $terminalExpenseId,
                    'job_expend_field' => $validatedData['job_expend_field'][$index],
                    'terminal_id' => $validatedData['terminal_id'],
                    'amount' => $validatedData['amount'][$index],
                    'status' => $validatedData['status'],
                ]
            );
        }
    }


    public function expenseUpdate(array $validatedData, TerminalExpense $terminalExpense): ?array
    {
        // Use a database transaction to ensure data integrity
        $terminalExpense = DB::transaction(function () use ($validatedData, $terminalExpense) {
           
            // Update the existing terminal expense record
            $terminalExpense->update([
                'terminal_id' => $validatedData['terminal_id'],
                'title' => $validatedData['title'],
                'job_type' => $validatedData['job_type'],
                'comission_rate' => $validatedData['comission_rate'],
                'minimum_comission' => $validatedData['minimum_comission'],
                'status' => $validatedData['status'],
            ]);

            // Update the job expense records associated with the terminal expense
            $this->updateJobExpenses($terminalExpense->uid, $validatedData);

            return $terminalExpense;
        });

        // Return the updated terminal expense data
        return [
            'terminalExpense' => $terminalExpense,
        ];
    }


    protected function updateJobExpenses($terminalExpenseId, array $validatedData): void
    {
        // Get all existing job expenses for this terminalExpenseId
        $existingJobExpenses = JobExpense::where('terminal_expense_id', $terminalExpenseId)->get();

        // Extract current job expenditure fields from the request
        $updatedFields = $validatedData['job_expend_field'];

        // Delete old records that are not in the updated request
        foreach ($existingJobExpenses as $expense) {
            if (!in_array($expense->job_expend_field, $updatedFields)) {
                $expense->delete();
            }
        }

        // Loop through the updated data
        foreach ($updatedFields as $index => $field) {
            // Find if the job expense already exists
            $jobExpense = JobExpense::where('terminal_expense_id', $terminalExpenseId)
                ->where('job_expend_field', $field)
                ->first();

            if ($jobExpense) {
                // Update existing record
                $jobExpense->update([
                    'terminal_id' => $validatedData['terminal_id'],
                    'amount' => $validatedData['amount'][$index],
                    'status' => $validatedData['status'],
                ]);
            } else {
                // Create new record if not found
                JobExpense::create([
                    'terminal_expense_id' => $terminalExpenseId,
                    'job_expend_field' => $field,
                    'terminal_id' => $validatedData['terminal_id'],
                    'amount' => $validatedData['amount'][$index],
                    'status' => $validatedData['status'],
                ]);
            }
        }
    }
}
