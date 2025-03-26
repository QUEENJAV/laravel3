<?php

namespace App\Services\Contracts;

use Illuminate\Http\UploadedFile;
interface FileStorageServiceInterface
{
    public function storeFile(UploadedFile $file, string $path): string;
}
