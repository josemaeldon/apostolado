<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Generate a storage URL with cache busting
     * Adds a version hash to prevent caching of updated images
     */
    public static function storageUrl($path)
    {
        if (!$path) {
            return self::appendVersion(self::placeholderUrl(), self::placeholderVersion());
        }

        $path = trim((string) $path);
        if ($path === '') {
            return self::appendVersion(self::placeholderUrl(), self::placeholderVersion());
        }

        // Preserve external absolute URLs and just add deterministic cache version.
        if (preg_match('#^https?://#i', $path)) {
            return self::appendVersion($path, (string) crc32($path));
        }

        $defaultDisk = config('filesystems.default', 'local');
        $candidateDisks = array_values(array_unique([$defaultDisk, 'public', 'minio', 's3', 'local']));
        $pathCandidates = self::pathCandidates($path);

        $resolvedDisk = null;
        $resolvedPath = null;
        $foundInStorage = false;

        foreach ($candidateDisks as $disk) {
            foreach ($pathCandidates as $candidatePath) {
                try {
                    if (Storage::disk($disk)->exists($candidatePath)) {
                        $resolvedDisk = $disk;
                        $resolvedPath = $candidatePath;
                        $foundInStorage = true;
                        break 2;
                    }
                } catch (\Throwable $e) {
                    // Ignore unavailable disk and continue fallback chain.
                }
            }
        }

        // If nothing was found, keep trying with default disk and first normalized candidate.
        // This preserves compatibility when `exists()` fails due provider limitations.
        $resolvedDisk = $resolvedDisk ?? $defaultDisk;
        $resolvedPath = $resolvedPath ?? ($pathCandidates[0] ?? ltrim($path, '/'));

        try {
            $url = Storage::disk($resolvedDisk)->url($resolvedPath);
        } catch (\Throwable $e) {
            // Final fallback for legacy local files under /storage.
            $url = asset('storage/' . ltrim($resolvedPath, '/'));
        }

        $version = null;

        // Use local mtime for files that are on public local storage.
        $fullPath = storage_path('app/public/' . $resolvedPath);
        if (File::exists($fullPath)) {
            $version = (int) filemtime($fullPath);
        } else {
            // For remote disks (MinIO/S3), try lastModified.
            try {
                $version = (int) Storage::disk($resolvedDisk)->lastModified($resolvedPath);
            } catch (\Throwable $e) {
                $version = null;
            }
        }

        // Avoid v=0 when providers don't expose modified date; use deterministic hash.
        if (empty($version)) {
            $version = (string) crc32($resolvedDisk . ':' . $resolvedPath);
        }

        // If the object was not found on any configured disk, use placeholder globally.
        if (!$foundInStorage) {
            return self::appendVersion(self::placeholderUrl(), self::placeholderVersion());
        }

        return self::appendVersion($url, $version);
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

    private static function placeholderUrl(): string
    {
        return asset('images/placeholders/image-unavailable.svg');
    }

    private static function placeholderVersion(): int
    {
        $placeholderPath = public_path('images/placeholders/image-unavailable.svg');
        return File::exists($placeholderPath) ? (int) filemtime($placeholderPath) : 1;
    }

    private static function appendVersion(string $url, $version): string
    {
        $separator = str_contains($url, '?') ? '&' : '?';
        return $url . $separator . 'v=' . $version;
    }

    private static function pathCandidates(string $path): array
    {
        $candidates = [];
        $bucket = trim((string) config('filesystems.disks.minio.bucket', ''), '/');

        $cleanPath = preg_replace('#\?.*$#', '', $path) ?? $path;
        $cleanPath = ltrim($cleanPath, '/');
        $candidates[] = $cleanPath;

        foreach (['storage/', 'public/', 'app/public/'] as $prefix) {
            if (str_starts_with($cleanPath, $prefix)) {
                $candidates[] = ltrim(substr($cleanPath, strlen($prefix)), '/');
            }
        }

        if ($bucket !== '' && str_starts_with($cleanPath, $bucket . '/')) {
            $candidates[] = ltrim(substr($cleanPath, strlen($bucket) + 1), '/');
        }

        return array_values(array_unique(array_filter($candidates)));
    }
}
