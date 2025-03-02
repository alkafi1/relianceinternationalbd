<?php

namespace App\Traits;
use Illuminate\Support\Str;

trait BaseModel
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically generate a UUID when creating a new user
        static::creating(function ($model) {
            $model->uid = Str::uuid()->toString();
        });
    }

    public static function findByColumn($column, $value)
    {
        $record = self::where($column, $value)->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => ucfirst(self::class) . ' not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => ucfirst(self::class) . ' retrieved successfully.',
            'data' => $record
        ], 200);
    }
}
