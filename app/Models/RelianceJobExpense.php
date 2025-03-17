<?php

namespace App\Models;


class RelianceJobExpense extends BaseModel
{
    protected $table = 'reliance_job_expenses';

    protected $fillable = [
        'job_id',
        'job_expend_field',
        'amount',
    ];
}
