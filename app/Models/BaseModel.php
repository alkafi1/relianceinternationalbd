<?php

namespace App\Models;

use App\Traits\CommonFillableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseModel extends Model
{

    use CommonFillableTrait;

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
                'status' => $status,
                'uid' => $uid
            ]
        ], 200);
    }

    /**
     * Update a record by a given column and value.
     *
     * @param string $column
     * @param mixed $value
     * @param array $data
     * @return array
     */
    public static function updateByColumn(string $column, $value, array $data): array
    {
        try {
            // Perform the update
            $result = static::where($column, $value)->update($data);

            // Check if the update was successful
            if ($result) {
                return [
                    'success' => true,
                    'message' => '<b>Record updated successfully.</b>',
                ];
            } else {
                return [
                    'success' => false,
                    'message' => '<b>No records found or no changes made.</b>',
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => '<b>An error occurred while updating the record.</b>',
            ];
        }
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

    /**
     * Fetch records based on status.
     *
     * @param string $statusColumn
     * @param string $statusValue
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function fetchByStatus(string $statusColumn, string $statusValue)
    {
        return static::where($statusColumn, $statusValue)->get();
    }
}
