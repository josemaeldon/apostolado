<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureCard extends Model
{
    protected $fillable = [
        'homepage_section_id',
        'title',
        'description',
        'featured_image',
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
     * Get the homepage section that owns the feature card.
     */
    public function homepageSection()
    {
        return $this->belongsTo(HomepageSection::class);
    }

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
        // Check if colors are hex codes
        if (preg_match('/^#[0-9A-Fa-f]{6}$/', $this->color_from)) {
            // Use inline styles for custom hex colors
            // Colors are validated by controller but we escape them for extra security
            $colorFrom = e($this->color_from);
            $colorTo = e($this->color_to);
            $borderColor = e($this->border_color);
            $textColor = e($this->text_color);
            
            return [
                'gradient' => '',
                'border' => '',
                'text' => '',
                'style' => sprintf(
                    'background: linear-gradient(to bottom right, %s, %s); border: 1px solid %s;',
                    $colorFrom,
                    $colorTo,
                    $borderColor
                ),
                'text_style' => sprintf('color: %s;', $textColor)
            ];
        }
        
        // Fallback to preset colors for backward compatibility
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
            'style' => '',
            'text_style' => ''
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
