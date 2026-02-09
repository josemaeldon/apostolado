<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeatureCard;
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
        return view('admin.feature-cards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:10',
            'color_from' => 'required|string|max:50',
            'color_to' => 'required|string|max:50',
            'border_color' => 'required|string|max:50',
            'text_color' => 'required|string|max:50',
            'order' => 'required|integer',
            'display_position' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        FeatureCard::create($validated);

        return redirect()->route('admin.feature-cards.index')
            ->with('success', 'Card criado com sucesso!');
    }

    public function edit(FeatureCard $featureCard)
    {
        return view('admin.feature-cards.edit', compact('featureCard'));
    }

    public function update(Request $request, FeatureCard $featureCard)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:10',
            'color_from' => 'required|string|max:50',
            'color_to' => 'required|string|max:50',
            'border_color' => 'required|string|max:50',
            'text_color' => 'required|string|max:50',
            'order' => 'required|integer',
            'display_position' => 'nullable|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        $validated['display_order'] = $validated['display_order'] ?? 0;

        $featureCard->update($validated);

        return redirect()->route('admin.feature-cards.index')
            ->with('success', 'Card atualizado com sucesso!');
    }

    public function destroy(FeatureCard $featureCard)
    {
        $featureCard->delete();

        return redirect()->route('admin.feature-cards.index')
            ->with('success', 'Card excluído com sucesso!');
    }
}
