<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{
    
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uid'; // Use 'uid' as the primary key

    /**
     * The "type" of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string'; // Primary key is a string (UUID)

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false; // Disable auto-incrementing for UUIDs

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically generate a UUID when creating a new model instance
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
}
