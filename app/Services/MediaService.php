<?php

namespace App\Services;

use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\UploadedFile as HttpUploadedFile;

class MediaService
{
    /**
     * Upload an image to a specific directory and return the file name.
     *
     * @param UploadedFile $image
     * @param string $directory
     * @return string|null
     */
    public static function uploadImage(HttpUploadedFile $image, string $directory = 'frontend/images'): ?string
    {
        if (!$image) {
            return null;
        }

        // Generate a unique filename
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        
        // Store the file in the specified directory (public disk)
        $image->move(public_path($directory), $imageName);

        return $imageName;
    }

    /**
     * Delete an image from the storage directory.
     *
     * @param string|null $imagePath
     * @param string $directory
     * @return bool
     */
    public static function deleteImage(?string $imagePath, string $directory = 'images'): bool
    {
        if ($imagePath && file_exists(public_path("$directory/$imagePath"))) {
            unlink(public_path("$directory/$imagePath"));
            return true;
        }

        return false;
    }
}
