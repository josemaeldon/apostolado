<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureCard;
use App\Models\HomepageSection;
use Illuminate\Http\Request;

class FeatureCardController extends Controller
{
    public function index()
    {
        $featureCards = FeatureCard::orderBy('order')->get();
        return view('admin.feature-cards.index', compact('featureCards'));
    }

    public function create()
    {
        $sections = HomepageSection::where('is_active', true)->orderBy('title')->get();
        return view('admin.feature-cards.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'homepage_section_id' => 'nullable|exists:homepage_sections,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'icon' => 'required|string|max:10',
            'color_from' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'color_to' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'border_color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'text_color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'order' => 'required|integer',
            'display_position' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'color_from.regex' => 'A cor inicial deve ser um código hexadecimal válido (ex: #FFFFFF).',
            'color_to.regex' => 'A cor final deve ser um código hexadecimal válido (ex: #FFFFFF).',
            'border_color.regex' => 'A cor da borda deve ser um código hexadecimal válido (ex: #FFFFFF).',
            'text_color.regex' => 'A cor do texto deve ser um código hexadecimal válido (ex: #FFFFFF).',
        ]);

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('feature-cards', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        FeatureCard::create($validated);

        // Redirect back to homepage section edit if card is associated with a section
        if (!empty($validated['homepage_section_id'])) {
            return redirect()->route('admin.homepage-sections.edit', $validated['homepage_section_id'])
                ->with('success', 'Card criado com sucesso!');
        }

        return redirect()->route('admin.feature-cards.index')
            ->with('success', 'Card criado com sucesso!');
    }

    public function edit(FeatureCard $featureCard)
    {
        $sections = HomepageSection::where('is_active', true)->orderBy('title')->get();
        return view('admin.feature-cards.edit', compact('featureCard', 'sections'));
    }

    public function update(Request $request, FeatureCard $featureCard)
    {
        $validated = $request->validate([
            'homepage_section_id' => 'nullable|exists:homepage_sections,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'icon' => 'required|string|max:10',
            'color_from' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'color_to' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'border_color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'text_color' => 'required|string|max:7|regex:/^#[0-9A-Fa-f]{6}$/',
            'order' => 'required|integer',
            'display_position' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'color_from.regex' => 'A cor inicial deve ser um código hexadecimal válido (ex: #FFFFFF).',
            'color_to.regex' => 'A cor final deve ser um código hexadecimal válido (ex: #FFFFFF).',
            'border_color.regex' => 'A cor da borda deve ser um código hexadecimal válido (ex: #FFFFFF).',
            'text_color.regex' => 'A cor do texto deve ser um código hexadecimal válido (ex: #FFFFFF).',
        ]);

        // Handle image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($featureCard->featured_image && \Storage::disk('public')->exists($featureCard->featured_image)) {
                \Storage::disk('public')->delete($featureCard->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')->store('feature-cards', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        $featureCard->update($validated);

        // Redirect back to homepage section edit if card is associated with a section
        if (!empty($validated['homepage_section_id'])) {
            return redirect()->route('admin.homepage-sections.edit', $validated['homepage_section_id'])
                ->with('success', 'Card atualizado com sucesso!');
        }

        return redirect()->route('admin.feature-cards.index')
            ->with('success', 'Card atualizado com sucesso!');
    }

    public function destroy(FeatureCard $featureCard)
    {
        $homepageSectionId = $featureCard->homepage_section_id;
        $featureCard->delete();

        // Redirect back to homepage section edit if card was associated with a section
        if (!empty($homepageSectionId)) {
            return redirect()->route('admin.homepage-sections.edit', $homepageSectionId)
                ->with('success', 'Card excluído com sucesso!');
        }

        return redirect()->route('admin.feature-cards.index')
            ->with('success', 'Card excluído com sucesso!');
    }
}
