<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrayerIntention;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PrayerIntentionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prayerIntentions = PrayerIntention::latest()->paginate(10);
        return view('admin.prayer-intentions.index', compact('prayerIntentions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.prayer-intentions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'month' => 'required|string|max:255',
            'year' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('prayer-intentions');
        }

        PrayerIntention::create($validated);

        return redirect()->route('admin.prayer-intentions.index')
            ->with('success', 'Intenção de oração criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PrayerIntention $prayerIntention)
    {
        return view('admin.prayer-intentions.show', compact('prayerIntention'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PrayerIntention $prayerIntention)
    {
        return view('admin.prayer-intentions.edit', compact('prayerIntention'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PrayerIntention $prayerIntention)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'month' => 'required|string|max:255',
            'year' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'video_url' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            if ($prayerIntention->image) {
                Storage::delete($prayerIntention->image);
            }
            $validated['image'] = $request->file('image')->store('prayer-intentions');
        }

        $prayerIntention->update($validated);

        return redirect()->route('admin.prayer-intentions.index')
            ->with('success', 'Intenção de oração atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PrayerIntention $prayerIntention)
    {
        if ($prayerIntention->image) {
            Storage::delete($prayerIntention->image);
        }
        
        $prayerIntention->delete();

        return redirect()->route('admin.prayer-intentions.index')
            ->with('success', 'Intenção de oração excluída com sucesso!');
    }
}
