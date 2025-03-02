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

    /**
     * Find a record by a specific column and return JSON response.
     *
     * @param string $column
     * @param mixed $value
     * @return \Illuminate\Http\JsonResponse
     */
    public static function getStatus($uid)
    {
        // Retrieve the 'status' value for the given UID
        $status = self::where('uid', $uid)->value('status');

        // Check if the status is null, meaning the agent was not found
        if (is_null($status)) {
            return response()->json([
                'success' => false,
                'message' => ucfirst(self::class) . ' not found.',
            ], 404);
        }

        // Return the status data as part of a successful response
        return response()->json([
            'success' => true,
            'message' => ucfirst(self::class) . ' retrieved successfully.',
            'data' => [
                'status' => $status
            ]
        ], 200);
    }


    /**
     * Delete the given model and return a response.
     *
     * @param Model $model
     * @return \Illuminate\Http\JsonResponse
     */
    public static function destroyModel(Model $model)
    {
        // Attempt to delete the model
        if ($model->delete()) {
            return response()->json([
                'success' => true,
                'message' => ucfirst(class_basename(get_class($model))) . ' deleted successfully.',
            ]);
        }

        // In case deletion fails
        return response()->json([
            'success' => false,
            'message' => ucfirst(class_basename(get_class($model))) . ' deletion failed.',
        ], 400);
    }
}
