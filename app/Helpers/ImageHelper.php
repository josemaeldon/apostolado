<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ImageHelper
{
    /**
     * Generate a storage URL with cache busting
     * Adds a version hash to prevent caching of updated images
     */
    public static function storageUrl($path)
    {
        if (!$path) {
            return null;
        }

        $defaultDisk = config('filesystems.default', 'local');
        $candidateDisks = array_values(array_unique([$defaultDisk, 'public', 'minio', 's3', 'local']));

        $resolvedDisk = null;
        foreach ($candidateDisks as $disk) {
            try {
                if (Storage::disk($disk)->exists($path)) {
                    $resolvedDisk = $disk;
                    break;
                }
            } catch (\Throwable $e) {
                // Ignore unavailable disk and continue fallback chain.
            }
        }

        // Fallback to default disk when existence checks fail.
        $resolvedDisk = $resolvedDisk ?? $defaultDisk;

        try {
            $url = Storage::disk($resolvedDisk)->url($path);
        } catch (\Throwable $e) {
            // Final fallback for legacy local files under /storage.
            $url = asset('storage/' . ltrim($path, '/'));
        }

        $version = 0;

        // Use local mtime for files that are on public local storage.
        $fullPath = storage_path('app/public/' . $path);
        if (File::exists($fullPath)) {
            $version = (int) filemtime($fullPath);
        } else {
            // For remote disks (MinIO/S3), try lastModified.
            try {
                $version = (int) Storage::disk($resolvedDisk)->lastModified($path);
            } catch (\Throwable $e) {
                $version = 0;
            }
        }

        $separator = str_contains($url, '?') ? '&' : '?';
        return $url . $separator . 'v=' . $version;
    }

    /**
     * Generate an asset URL with cache busting for public assets
     */
    public static function assetUrl($path)
    {
        if (!$path) {
            return null;
        }

        $url = asset($path);
        
        // Add version parameter for cache busting
        $fullPath = public_path($path);
        if (File::exists($fullPath)) {
            $lastModified = filemtime($fullPath);
            $url .= '?v=' . $lastModified;
        }
        
        return $url;
    }
}
