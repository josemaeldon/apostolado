<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use App\Models\PrayerIntention;
use App\Models\MediaGallery;
use App\Models\Page;
use App\Models\Category;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Display all prayer intentions
     */
    public function prayerIntentions()
    {
        $prayerIntentions = PrayerIntention::where('is_published', true)
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->paginate(12);
        
        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
        
        return view('public.prayer-intentions', compact('prayerIntentions', 'categories'));
    }

    /**
     * Display single prayer intention
     */
    public function showPrayerIntention(PrayerIntention $prayerIntention)
    {
        if (!$prayerIntention->is_published) {
            abort(404);
        }

        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
        
        return view('public.prayer-intention-show', compact('prayerIntention', 'categories'));
    }

    /**
     * Display all articles or filtered by category
     */
    public function articles(Request $request)
    {
        $query = Article::where('is_published', true);

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        $articles = $query->latest('published_at')->paginate(12);
        
        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
        
        return view('public.articles', compact('articles', 'categories'));
    }

    /**
     * Display single article
     */
    public function showArticle(Article $article)
    {
        if (!$article->is_published) {
            abort(404);
        }

        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
        
        return view('public.article-show', compact('article', 'categories'));
    }

    /**
     * Display all events
     */
    public function events()
    {
        $events = Event::where('is_published', true)
            ->where('start_date', '>=', now())
            ->orderBy('start_date')
            ->paginate(12);
        
        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
        
        return view('public.events', compact('events', 'categories'));
    }

    /**
     * Display single event
     */
    public function showEvent(Event $event)
    {
        if (!$event->is_published) {
            abort(404);
        }

        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
        
        return view('public.event-show', compact('event', 'categories'));
    }

    /**
     * Display media gallery
     */
    public function mediaGallery(Request $request)
    {
        $query = MediaGallery::where('is_published', true);

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        $mediaItems = $query->orderBy('order')->paginate(12);
        
        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
        
        return view('public.media-gallery', compact('mediaItems', 'categories'));
    }

    /**
     * Display single page
     */
    public function showPage(Page $page)
    {
        if (!$page->is_published) {
            abort(404);
        }

        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
        
        return view('public.page-show', compact('page', 'categories'));
    }
}
