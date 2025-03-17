<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RelianceJobExpenseSummury extends BaseModel
{
    protected $table = 'reliance_job_expense_summuries';

    protected $fillable = [
        'job_id',
        'agency_commission',
        'total_expenses',
        'advanced_received',
        'due',
        'grand_total',
    ];
}
