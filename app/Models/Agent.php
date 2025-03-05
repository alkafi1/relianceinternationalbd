<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Agent extends BaseModel
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'uid',
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

    /**
     * The "booting" method of the model.
     *
     * Automatically generates the agent_id on creation.
     *
     * @return void
     */ /**
     * The "booting" method of the model.
     *
     * Automatically generates the agent_id on creation.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($agent) {
            // Check if agent_id is not already set (to prevent overriding)
            if (!$agent->agent_id) {
                // Get the latest agent with the prefix 'Agent-'
                $latestAgent = self::where('agent_id', 'like', 'Agent-%')
                    ->orderByDesc('agent_id') // Order by the latest agent based on id
                    ->first();

                // Extract the numeric part of the last agent_id or set it to 0 if no agents exist
                $latestAgentIdNumber = $latestAgent ? (int) substr($latestAgent->agent_id, 6) : 0;

                // Increment the agent_id number
                $newAgentIdNumber = str_pad($latestAgentIdNumber + 1, 2, '0', STR_PAD_LEFT);

                // Generate the new agent_id
                $newAgentId = 'Agent-' . $newAgentIdNumber;

                // Ensure the new agent_id is unique
                while (self::where('agent_id', $newAgentId)->exists()) {
                    // If the generated agent_id already exists, increment the number again
                    $newAgentIdNumber++;
                    $newAgentId = 'Agent-' . str_pad($newAgentIdNumber, 2, '0', STR_PAD_LEFT);
                }

                // Set the new agent_id
                $agent->agent_id = $newAgentId;
            }
        });
    }

    /**
     * Get the accounts for the user.
     */
    public function accounts()
    {
        return $this->morphMany(Account::class, 'account_holder');
    }
}
