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
        'display_position',
        'display_order',
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
    
    /**
     * Get available position options for display
     */
    public static function getPositionOptions(): array
    {
        return [
            'above_slider' => 'Acima do Slider',
            'below_slider' => 'Abaixo do Slider',
            'above_features' => 'Acima dos Cards de Recursos',
            'below_features' => 'Abaixo dos Cards de Recursos',
            'above_events' => 'Acima dos Eventos',
            'below_events' => 'Abaixo dos Eventos',
            'above_articles' => 'Acima dos Artigos',
            'below_articles' => 'Abaixo dos Artigos',
            'above_cta' => 'Acima da Chamada para Ação',
            'below_cta' => 'Abaixo da Chamada para Ação',
        ];
    }
    
    /**
     * Get extended color presets with more options
     */
    public static function getExtendedColorPresets(): array
    {
        return [
            'primary' => [
                'name' => 'Primary (Azul)',
                'from' => 'primary-50',
                'to' => 'white',
                'border' => 'primary-100',
                'text' => 'primary-800',
            ],
            'gold' => [
                'name' => 'Dourado',
                'from' => 'gold-50',
                'to' => 'white',
                'border' => 'gold-100',
                'text' => 'gold-800',
            ],
            'neutral' => [
                'name' => 'Neutro (Cinza)',
                'from' => 'neutral-50',
                'to' => 'white',
                'border' => 'neutral-200',
                'text' => 'neutral-900',
            ],
            'blue' => [
                'name' => 'Azul Claro',
                'from' => 'blue-50',
                'to' => 'white',
                'border' => 'blue-100',
                'text' => 'blue-800',
            ],
            'green' => [
                'name' => 'Verde',
                'from' => 'green-50',
                'to' => 'white',
                'border' => 'green-100',
                'text' => 'green-800',
            ],
        ];
    }
}
