<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use App\Models\FeatureCard;
use Illuminate\Http\Request;

class HomepageSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = HomepageSection::all();
        $featureCards = FeatureCard::orderBy('order')->get();
        return view('admin.homepage-sections.index', compact('sections', 'featureCards'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.homepage-sections.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:homepage_sections,key|regex:/^[a-z0-9_-]+$/',
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'display_position' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'key.regex' => 'A chave deve conter apenas letras minúsculas, números, underscores (_) e hífens (-).',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        HomepageSection::create($validated);

        return redirect()->route('admin.homepage-sections.index')
            ->with('success', 'Seção criada com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HomepageSection $homepageSection)
    {
        return view('admin.homepage-sections.edit', compact('homepageSection'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, HomepageSection $homepageSection)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'display_position' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        $homepageSection->update($validated);

        return redirect()->route('admin.homepage-sections.index')
            ->with('success', 'Seção atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HomepageSection $homepageSection)
    {
        $homepageSection->delete();

        return redirect()->route('admin.homepage-sections.index')
            ->with('success', 'Seção excluída com sucesso!');
    }
}
