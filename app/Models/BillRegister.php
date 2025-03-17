<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillRegister extends BaseModel
{
    protected $table = 'bill_registers';

    protected $fillable = [
        'job_id',
        'party_id',
        'job_no',
        'bill_no',
        'bill_amount',
        'bill_date',
        'received_amount',
        'received_date',
        'due_amount',
        'remarks',
    ];
}
