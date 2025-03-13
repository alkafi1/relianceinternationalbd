<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'jobs';
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
        'buyer_name',
        'invoice_no',
        'value_usd',
        'usd_rate',
        'item',
        'terminal',
        'bill_to',
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
        'truck_agent',
        'status',
        'voucher_amount',
        'job_no',
    ];

}
