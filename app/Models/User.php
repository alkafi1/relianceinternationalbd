<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // Ensure this line is present

class User extends Authenticatable
{

    use HasFactory, Notifiable, HasRoles, BaseModel;

    // Set the primary key
    protected $primaryKey = 'uid';

    // Set the key type to string (for UUID)
    protected $keyType = 'string';

    // Disable auto-incrementing (since UUIDs are used)
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid', // Add uid to fillable if you plan to set it manually
        'first_name',
        'last_name',
        'email',
        'password',
        'status',
        'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the display name.
     */
    public function displayName(): string
    {
        return isset($this->first_name, $this->last_name) ? "{$this->first_name} {$this->last_name}" : '';
    }

    /**
     * Get the accounts for the user.
     */
    public function accounts()
    {
        return $this->morphMany(Account::class, 'account_holder');
    }
}
