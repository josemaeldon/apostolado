<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureCard extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon',
        'color_from',
        'color_to',
        'border_color',
        'text_color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
