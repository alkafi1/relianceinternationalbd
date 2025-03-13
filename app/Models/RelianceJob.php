<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class RelianceJob extends BaseModel
{
    use HasFactory;

    protected $table = 'reliance_jobs';
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'uid';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'terminal_id',
        'party_id',
        'agent_id',
        'buyer_name',
        'invoice_no',
        'value_usd',
        'usd_rate',
        'item',
        'lc_no',
        'be_no',
        'ud_no',
        'ud_amendment_no',
        'job_type',
        'master_bl_number',
        'house_bl_number',
        'quantity',
        'ctns_pieces',
        'weight',
        'status',
        'voucher_amount',
        'job_no',
    ];
}
