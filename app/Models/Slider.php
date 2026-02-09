<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'button_text',
        'button_link',
        'linkable_type',
        'linkable_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the linkable model (Page, Article, or Event).
     */
    public function linkable()
    {
        return $this->morphTo();
    }

    /**
     * Get the effective link for this slider.
     */
    public function getEffectiveLinkAttribute()
    {
        if ($this->linkable) {
            if ($this->linkable instanceof \App\Models\Page) {
                return route('public.page.show', $this->linkable);
            } elseif ($this->linkable instanceof \App\Models\Article) {
                return route('public.article.show', $this->linkable);
            } elseif ($this->linkable instanceof \App\Models\Event) {
                return route('public.event.show', $this->linkable);
            }
        }
        return $this->button_link;
    }
}
