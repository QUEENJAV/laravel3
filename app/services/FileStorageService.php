<?php

namespace App\Services;

use App\Services\Contracts\FileStorageServiceInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Support\Facades\Log;

class FileStorageService implements FileStorageServiceInterface
{
    public function __construct()
    {
        //
    }
    public function storeFile(UploadedFile $file, string $path): string
    {
        try {
            $imagePath = $file->store($path, 'public');
            return config('app.url') . '/storage/' . $imagePath;
        } catch (Exception $e) {
            Log::error('File upload failed: ' . $e->getMessage());
            throw new \RuntimeException('File upload failed');
        }
    }

}
