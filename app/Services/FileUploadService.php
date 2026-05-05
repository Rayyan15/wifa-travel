<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    /**
     * Store an uploaded file in the given path on the public disk.
     */
    public function storeFile(UploadedFile $file, string $path): string
    {
        return $file->store($path, 'public');
    }

    /**
     * Delete a file from the public disk if it exists.
     */
    public function deleteFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
