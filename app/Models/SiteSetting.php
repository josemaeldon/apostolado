<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("site_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Get multiple settings at once
     */
    public static function getMultiple(array $keys, array $defaults = []): array
    {
        $cacheKey = 'site_settings_' . md5(implode(',', $keys));
        
        return Cache::remember($cacheKey, 3600, function () use ($keys, $defaults) {
            $settings = self::whereIn('key', $keys)->pluck('value', 'key')->toArray();
            
            $result = [];
            foreach ($keys as $key) {
                $result[$key] = $settings[$key] ?? ($defaults[$key] ?? null);
            }
            
            return $result;
        });
    }

    /**
     * Set a setting value by key
     */
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
        
        Cache::forget("site_setting_{$key}");
    }

    /**
     * Clear all setting cache
     */
    public static function clearCache(): void
    {
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget("site_setting_{$setting->key}");
        }
    }
}
