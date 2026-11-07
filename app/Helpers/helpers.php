<?php

use App\Helpers\UploadHelper;

if (!function_exists('image_url')) {
    function image_url(?string $path, ?string $fallback = null): ?string
    {
        return UploadHelper::url($path, $fallback);
    }
}

if (!function_exists('upload_image')) {
    function upload_image($file, string $folder = 'uploads', int $maxWidth = 800, int $maxHeight = 800, int $quality = 80): ?string
    {
        return UploadHelper::uploadImage($file, $folder, $maxWidth, $maxHeight, $quality);
    }
}
