<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use App\Models\Article;
use App\Models\Category;
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
        
        return view('welcome', compact('sliders', 'articles', 'categories'));
    }
}
