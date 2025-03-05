<?php

namespace App\Services;

use App\Models\terminal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class TerminalService
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

    
}
