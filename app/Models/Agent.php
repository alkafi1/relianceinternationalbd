<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\BaseModel as TraitsBaseModel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class Agent extends Authenticatable
{
    use HasFactory, TraitsBaseModel, HasRoles;
    // Set the primary key
    protected $primaryKey = 'uid';

    // Set the key type to string (for UUID)
    protected $keyType = 'string';

    // Disable auto-incrementing (since UUIDs are used)
    public $incrementing = false;
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

        // Set `created_by` when creating
        static::creating(function ($model) {
            if (auth()->check() || auth('agent')->check() || auth('web')->check()) {
                $model->created_by_uid = auth()->user()->uid ?? auth('agent')->user()->uid ?? auth('web')->user()->uid;
                $model->created_by_type = get_class($model);
            }
        });

        // Set `updated_by` when updating
        static::updating(function ($model) {
            if (auth()->check() || auth('agent')->check() || auth('web')->check()) {
                $model->updated_by_uid = auth()->user()->uid ?? auth('agent')->user()->uid ?? auth('web')->user()->uid;
                $model->updated_by_type = get_class($model);
            }
        });

        // Set `deleted_by` when deleting
        static::deleting(function ($model) {
            if (auth()->check() || auth('agent')->check() || auth('web')->check()) {
                $model->deleted_by_uid = auth()->user()->uid ?? auth('agent')->user()->uid ?? auth('web')->user()->uid;
                $model->deleted_by_type = get_class($model);
                $model->save(); // Save the `deleted_by` field before deletion
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

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function thana()
    {
        return $this->belongsTo(Thana::class);
    }

    public function created_by()
    {
        return $this->morphTo(__FUNCTION__, 'created_by_type', 'created_by_uid');
    }
}
