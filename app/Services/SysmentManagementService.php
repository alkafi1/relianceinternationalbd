<?php

namespace App\Services;

use App\Enums\AdminStatus;
use App\Models\Agent;
use App\Models\SystemConten;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SysmentManagementService
{
    /**
     * Create a new agent.
     *
     * @param array $validatedData Validated user input
     * @return array|null
     */
    public function store(array $validatedData): ?array
    {
        $updatedRecords = [];

    // Handle Image Uploads
    if (!empty($validatedData['logo'])) {
        $validatedData['logo'] = MediaService::uploadImage($validatedData['logo']);
    }
    if (!empty($validatedData['favicon'])) {
        $validatedData['favicon'] = MediaService::uploadImage($validatedData['favicon']);
    }
    // Update or insert content
    foreach ($validatedData as $key => $value) {
        if (in_array($key, ['logo', 'favicon'])) {
            $systemContent = SystemConten::updateOrCreate(
                ['name' => $key],
                ['media' => $value,]
            );

            $updatedRecords[$key] = $systemContent; // Store the updated record
            continue; // Skip file fields
        }

        $systemContent = SystemConten::updateOrCreate(
            ['name' => $key],
            ['content' => $value,]
        );

        $updatedRecords[$key] = $systemContent; // Store the updated record
    }

    // Return the updated records
    return [
        'systemContent' => $updatedRecords,
    ];
    }
}
