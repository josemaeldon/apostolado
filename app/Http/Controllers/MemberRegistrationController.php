<?php

namespace App\Http\Controllers;

use App\Models\MemberRegistration;
use App\Models\Category;
use Illuminate\Http\Request;

class MemberRegistrationController extends Controller
{
    public function create()
    {
        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
            
        return view('member-registration', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'parish' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'birth_date' => 'required|date',
            'marital_status' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'member_city' => 'required|string|max:255',
            'member_parish' => 'required|string|max:255',
            'baptism_date' => 'nullable|date',
            'commitment_1' => 'boolean',
            'commitment_2' => 'boolean',
            'commitment_3' => 'boolean',
            'commitment_4' => 'boolean',
            'commitment_5' => 'boolean',
            'how_met' => 'nullable|string',
            'why_join' => 'nullable|string',
        ]);

        MemberRegistration::create($validated);

        return redirect()->route('member.register')
            ->with('success', 'Cadastro realizado com sucesso! Entraremos em contato em breve.');
    }
}
