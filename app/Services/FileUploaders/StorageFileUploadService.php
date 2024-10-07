<?php

namespace App\Services\FileUploaders;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageFileUploadService
{
    /**
     * @param string $path
     * @param \Illuminate\Http\UploadedFile $file
     * @param bool $returnUrl
     * @return string|null
     */
    public static function store(string $path, UploadedFile $file, bool $returnUrl = true): ?string
    {
        $uploadedPath = Storage::putFile($path, $file);

        if (!$uploadedPath) {
            return null;
        }

        return $returnUrl ? Storage::url($uploadedPath) : $uploadedPath;
    }
}
