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

    /**
     * Get predefined CSS class combinations to ensure Tailwind purge works
     */
    public static function getColorPresets(): array
    {
        return [
            'primary' => [
                'gradient' => 'bg-gradient-to-br from-primary-50 to-white',
                'border' => 'border-primary-100',
                'text' => 'text-primary-800',
            ],
            'gold' => [
                'gradient' => 'bg-gradient-to-br from-gold-50 to-white',
                'border' => 'border-gold-100',
                'text' => 'text-gold-800',
            ],
            'neutral' => [
                'gradient' => 'bg-gradient-to-br from-neutral-50 to-white',
                'border' => 'border-neutral-200',
                'text' => 'text-neutral-900',
            ],
        ];
    }

    /**
     * Get the CSS classes for this card
     */
    public function getCssClasses(): array
    {
        $presets = self::getColorPresets();
        
        // Map stored values to preset names
        $presetKey = match($this->color_from) {
            'gold-50' => 'gold',
            'neutral-50' => 'neutral',
            default => 'primary',
        };
        
        $preset = $presets[$presetKey];
        
        return [
            'gradient' => $preset['gradient'],
            'border' => 'border ' . $preset['border'],
            'text' => $preset['text'],
        ];
    }
}
