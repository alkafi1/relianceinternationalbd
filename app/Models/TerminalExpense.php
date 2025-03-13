<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TerminalExpense extends BaseModel
{
    use HasFactory;
    protected $table = 'terminal_expenses';
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
        'terminal_id',
        'title',
        'job_type',
        'comission_rate',
        'minimum_comission',
        'status',
    ];

    /**
     * Get the job expenditures for the terminal expense.
     */
    public function jobExpense()
    {
        return $this->hasMany(Jobexpense::class, 'terminal_expense_id');
    }

    public function terminal()
    {
        return $this->belongsTo(Terminal::class, 'terminal_id');
    }
}
