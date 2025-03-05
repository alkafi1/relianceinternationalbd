<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'account_holder_uid',
        'account_holder_type',
        'account_name',
        'account_type',
        'current_balance',
    ];

    /**
     * Get the account holder (polymorphic relationship).
     */
    public function accountHolder()
    {
        return $this->morphTo();
    }
}
