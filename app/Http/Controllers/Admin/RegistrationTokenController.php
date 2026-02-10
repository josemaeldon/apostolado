<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrationToken;
use Illuminate\Http\Request;

class RegistrationTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tokens = RegistrationToken::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.registration-tokens.index', compact('tokens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.registration-tokens.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $validated['token'] = RegistrationToken::generateToken();
        $validated['is_active'] = $request->has('is_active');

        RegistrationToken::create($validated);

        return redirect()->route('admin.registration-tokens.index')
            ->with('success', 'Token criado com sucesso!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegistrationToken $registrationToken)
    {
        return view('admin.registration-tokens.edit', compact('registrationToken'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegistrationToken $registrationToken)
    {
        $validated = $request->validate([
            'description' => 'nullable|string|max:255',
            'is_active' => 'boolean',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $registrationToken->update($validated);

        return redirect()->route('admin.registration-tokens.index')
            ->with('success', 'Token atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegistrationToken $registrationToken)
    {
        $registrationToken->delete();

        return redirect()->route('admin.registration-tokens.index')
            ->with('success', 'Token excluído com sucesso!');
    }
}
