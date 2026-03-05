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

        // Get the full path to the file
        $fullPath = storage_path('app/public/' . $path);
        
        // Generate URL with cache buster
        $url = Storage::url($path);
        
        // If the file exists, add its modification time as a version parameter
        if (File::exists($fullPath)) {
            $lastModified = filemtime($fullPath);
            $url .= '?v=' . $lastModified;
        } else {
            // If file doesn't exist, still add a version to prevent caching issues
            $url .= '?v=0';
        }
        
        return $url;
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
