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
        'created_by_id',
        'updated_by',
        'deleted_by',
    ];

    public function terminal()
    {
        return $this->belongsTo(Terminal::class, 'terminal_id');
    }

    public function party()
    {
        return $this->belongsTo(Party::class, 'party_id');
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by_type = auth()->guard('web')->check() ? 'App\Models\User' : 'App\Models\Agent';
            $model->created_by_uid = auth()->user()->uid ?? auth()->guard('agent')->user()->uid;
        });

        static::updating(function ($model) {
            $model->updated_by_type = auth()->guard('web')->check() ? 'App\Models\User' : 'App\Models\Agent';
            $model->updated_by_uid = auth()->user()->uid ?? auth()->guard('agent')->user()->uid;
        });

        static::deleting(function ($model) {
            $model->deleted_by_type = auth()->guard('web')->check() ? 'App\Models\User' : 'App\Models\Agent';
            $model->deleted_by_uid = auth()->user()->uid ?? auth()->guard('agent')->user()->uid;
            $model->save();
        });
    }

    public function createdBy()
    {
        return $this->morphTo(__FUNCTION__, 'created_by_type', 'created_by_uid');
    }

    public function updatedBy()
    {
        return $this->morphTo(__FUNCTION__, 'updated_by_type', 'updated_by_uid');
    }

    public function deletedBy()
    {
        return $this->morphTo(__FUNCTION__, 'deleted_by_type', 'deleted_by_uid');
    }


}
