<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSection extends Model
{
    protected $fillable = [
        'key',
        'title',
        'subtitle',
        'display_position',
        'display_order',
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
}
