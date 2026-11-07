<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class UploadHelper
{
    /**
     * Upload an image safely.
     * On local development with writable disk, it can save to storage/app/public.
     * On Vercel / serverless / read-only filesystem, it automatically compresses and encodes as a Base64 Data URI.
     */
    public static function uploadImage(?UploadedFile $file, string $folder = 'uploads', int $maxWidth = 800, int $maxHeight = 800, int $quality = 80): ?string
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        // Try local storage only if environment is local AND folder is writable
        if (app()->environment('local')) {
            try {
                return $file->store($folder, 'public');
            } catch (\Throwable $e) {
                \Log::info("Local disk storage failed, falling back to base64: " . $e->getMessage());
            }
        }

        // Production / Vercel: Compress & convert to Base64 Data URI
        return self::convertToOptimizedBase64($file, $maxWidth, $maxHeight, $quality);
    }

    /**
     * Delete an existing image if it is stored on the public disk.
     */
    public static function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }

        // If it's a data URI or external URL, no local disk file to delete
        if (str_starts_with($path, 'data:') || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        try {
            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        } catch (\Throwable $e) {
            \Log::warning("Gagal menghapus file: " . $e->getMessage());
        }
    }

    /**
     * Convert an uploaded image to an optimized Base64 Data URI using GD.
     */
    public static function convertToOptimizedBase64(UploadedFile $file, int $maxWidth = 800, int $maxHeight = 800, int $quality = 80): ?string
    {
        try {
            $realPath = $file->getRealPath();
            $mime = strtolower($file->getMimeType() ?: '');

            if (extension_loaded('gd') && in_array($mime, ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'])) {
                $img = match ($mime) {
                    'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($realPath),
                    'image/png' => @imagecreatefrompng($realPath),
                    'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($realPath) : null,
                    default => null,
                };

                if ($img) {
                    $origW = imagesx($img);
                    $origH = imagesy($img);

                    $ratio = min($maxWidth / $origW, $maxHeight / $origH, 1.0);
                    $newW = (int)round($origW * $ratio);
                    $newH = (int)round($origH * $ratio);

                    $target = imagecreatetruecolor($newW, $newH);

                    // Preserve transparency for PNG and WebP
                    imagealphablending($target, false);
                    imagesavealpha($target, true);

                    imagecopyresampled($target, $img, 0, 0, 0, 0, $newW, $newH, $origW, $origH);

                    ob_start();
                    if (function_exists('imagewebp')) {
                        imagewebp($target, null, $quality);
                        $outputMime = 'image/webp';
                    } elseif ($mime === 'image/png') {
                        imagepng($target, null, 7);
                        $outputMime = 'image/png';
                    } else {
                        imagejpeg($target, null, $quality);
                        $outputMime = 'image/jpeg';
                    }
                    $data = ob_get_clean();

                    imagedestroy($img);
                    imagedestroy($target);

                    if (!empty($data)) {
                        return "data:{$outputMime};base64," . base64_encode($data);
                    }
                }
            }

            // Fallback for SVG or when GD cannot process
            $content = file_get_contents($realPath);
            return "data:{$mime};base64," . base64_encode($content);

        } catch (\Throwable $e) {
            \Log::error("Failed to convert image to base64: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get image URL whether it's Base64 Data URI, HTTP URL, or storage path.
     */
    public static function url(?string $path, ?string $fallback = null): ?string
    {
        if (empty($path)) {
            return $fallback;
        }

        if (str_starts_with($path, 'data:') || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset('storage/' . ltrim($path, '/'));
    }
}
