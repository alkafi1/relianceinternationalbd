<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Jobexpense extends BaseModel
{
    use HasFactory;
    
    protected $table = 'job_expenses';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'terminal_id',         // Foreign key to Terminal
        'terminal_expense_id', // Foreign key to TerminalExpense
        'job_expend_field',    // Name of the expenditure field
        'amount',              // Amount associated with the expenditure
    ];

    /**
     * Get the terminal expense that owns the job expense.
     */
    public function terminalExpense()
    {
        return $this->belongsTo(TerminalExpense::class);
    }
}
