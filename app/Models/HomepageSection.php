<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    /**
     * Get a section by its key
     */
    public static function getByKey(string $key)
    {
        return static::where('key', $key)->where('is_active', true)->first();
    }
}
