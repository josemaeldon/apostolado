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
            'cpf' => 'required|string|size:14|unique:member_registrations,cpf|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            'address' => 'required|string',
            'phone' => 'required|string|size:14|regex:/^\(\d{2}\)\d{5}-\d{4}$/',
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
        ], [
            'cpf.unique' => 'Este CPF já está cadastrado em nosso sistema.',
            'cpf.regex' => 'O CPF deve estar no formato 000.000.000-00',
            'cpf.size' => 'O CPF deve estar no formato 000.000.000-00',
            'phone.regex' => 'O telefone deve estar no formato (00)99999-9999',
            'phone.size' => 'O telefone deve estar no formato (00)99999-9999',
        ]);

        MemberRegistration::create($validated);

        return redirect()->route('member.register')
            ->with('success', 'Cadastro realizado com sucesso! Entraremos em contato em breve.');
    }
}
