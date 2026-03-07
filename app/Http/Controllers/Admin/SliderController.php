<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Page;
use App\Models\Article;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')->paginate(10);
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        $pages = Page::where('is_published', true)->orderBy('title')->get();
        $articles = Article::where('is_published', true)->orderBy('title')->get();
        $events = Event::where('is_published', true)->orderBy('title')->get();
        return view('admin.sliders.create', compact('pages', 'articles', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255|required_if:link_type,custom',
            'link_type' => 'required|in:page,article,event,custom',
            'link_id' => 'nullable|integer',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->link_type !== 'custom') {
            $request->validate([
                'link_id' => [
                    'required',
                    Rule::exists(match ($request->link_type) {
                        'page' => 'pages',
                        'article' => 'articles',
                        'event' => 'events',
                    }, 'id'),
                ],
            ]);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders');
        }

        // Keep link data mutually exclusive: either internal target or custom URL.
        if ($request->link_type === 'custom') {
            $validated['linkable_type'] = null;
            $validated['linkable_id'] = null;
        } else {
            $validated['linkable_type'] = match ($request->link_type) {
                'page' => \App\Models\Page::class,
                'article' => \App\Models\Article::class,
                'event' => \App\Models\Event::class,
            };
            $validated['linkable_id'] = $request->integer('link_id');
            $validated['button_link'] = null;
        }

        // Remove helper fields
        unset($validated['link_type'], $validated['link_id']);

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider criado com sucesso!');
    }

    public function edit(Slider $slider)
    {
        $pages = Page::where('is_published', true)->orderBy('title')->get();
        $articles = Article::where('is_published', true)->orderBy('title')->get();
        $events = Event::where('is_published', true)->orderBy('title')->get();
        return view('admin.sliders.edit', compact('slider', 'pages', 'articles', 'events'));
    }

    public function update(Request $request, Slider $slider)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255|required_if:link_type,custom',
            'link_type' => 'required|in:page,article,event,custom',
            'link_id' => 'nullable|integer',
            'order' => 'required|integer',
            'is_active' => 'boolean',
        ]);

        if ($request->link_type !== 'custom') {
            $request->validate([
                'link_id' => [
                    'required',
                    Rule::exists(match ($request->link_type) {
                        'page' => 'pages',
                        'article' => 'articles',
                        'event' => 'events',
                    }, 'id'),
                ],
            ]);
        }

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::delete($slider->image);
            }
            $validated['image'] = $request->file('image')->store('sliders');
        }

        // Keep link data mutually exclusive: either internal target or custom URL.
        if ($request->link_type === 'custom') {
            $validated['linkable_type'] = null;
            $validated['linkable_id'] = null;
        } else {
            $validated['linkable_type'] = match ($request->link_type) {
                'page' => \App\Models\Page::class,
                'article' => \App\Models\Article::class,
                'event' => \App\Models\Event::class,
            };
            $validated['linkable_id'] = $request->integer('link_id');
            $validated['button_link'] = null;
        }

        // Remove helper fields
        unset($validated['link_type'], $validated['link_id']);

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider atualizado com sucesso!');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::delete($slider->image);
        }
        
        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider excluído com sucesso!');
    }
}
