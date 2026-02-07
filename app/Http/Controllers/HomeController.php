<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Article;
use App\Models\Category;
use App\Models\Event;
use App\Models\FeatureCard;
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
        
        $featureCards = FeatureCard::where('is_active', true)
            ->orderBy('order')
            ->get();
        
        return view('welcome', compact('sliders', 'articles', 'categories', 'events', 'featureCards'));
    }
}
