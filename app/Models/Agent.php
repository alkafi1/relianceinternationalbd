<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Agent extends BaseModel
{
    use HasFactory;
    
    
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uuid',
        'agent_id',
        'first_name',
        'last_name',
        'age',
        'email',
        'phone',
        'password',
        'address',
        'division_id',
        'district_id',
        'thana_id',
        'status',
        'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     */
    protected $hidden = [
        'password',
    ];

    
    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = ['display_name'];

    /**
     * Get the display name.
     */
    public function getDisplayNameAttribute(): string
    {
        return isset($this->first_name, $this->last_name) ? "{$this->first_name} {$this->last_name}" : '';
    }

    
}
