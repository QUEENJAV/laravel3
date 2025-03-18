<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
interface FileStorageServiceInterface
{
    public function storeFile(UploadedFile $file, string $path): string;
}
