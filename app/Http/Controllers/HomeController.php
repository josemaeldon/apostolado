<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Article;
use App\Models\Category;
use App\Models\Event;
use App\Models\FeatureCard;
use App\Models\HomepageSection;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        $articles = Article::where('is_published', true)
            ->latest('published_at')
            ->take(6)
            ->get();
        
        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
        
        $events = Event::where('is_published', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(3)
            ->get();
        
        // Get feature cards for default position
        $featureCards = FeatureCard::where('is_active', true)
            ->whereNull('display_position')
            ->orderBy('order')
            ->get();
        
        $aboutSection = HomepageSection::getByKey('about_section');
        
        // Group sections and cards by position
        $positions = [
            'above_slider' => [],
            'below_slider' => [],
            'above_features' => [],
            'below_features' => [],
            'above_events' => [],
            'below_events' => [],
            'above_articles' => [],
            'below_articles' => [],
            'above_cta' => [],
            'below_cta' => [],
        ];
        
        // Get custom positioned sections
        $customSections = HomepageSection::where('is_active', true)
            ->whereNotNull('display_position')
            ->orderBy('display_order')
            ->get();
        
        foreach ($customSections as $section) {
            if (isset($positions[$section->display_position])) {
                $positions[$section->display_position][] = [
                    'type' => 'section',
                    'data' => $section,
                ];
            }
        }
        
        // Get custom positioned feature cards
        $customCards = FeatureCard::where('is_active', true)
            ->whereNotNull('display_position')
            ->orderBy('display_order')
            ->get();
        
        foreach ($customCards as $card) {
            if (isset($positions[$card->display_position])) {
                $positions[$card->display_position][] = [
                    'type' => 'card',
                    'data' => $card,
                ];
            }
        }
        
        return view('welcome', compact('sliders', 'articles', 'categories', 'events', 'featureCards', 'aboutSection', 'positions'));
    }
}
