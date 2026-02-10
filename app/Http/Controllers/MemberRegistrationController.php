<?php

namespace App\Http\Controllers;

use App\Models\MemberRegistration;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberRegistrationController extends Controller
{
    public function showTokenForm()
    {
        return view('member-token-form');
    }

    public function validateToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string|size:5|regex:/^[A-Z]{3}\d{2}$/',
        ], [
            'token.required' => 'Por favor, insira o token.',
            'token.size' => 'O token deve ter 5 caracteres (3 letras e 2 números).',
            'token.regex' => 'O token deve conter 3 letras maiúsculas seguidas de 2 números (ex: ABC12).',
        ]);

        $token = strtoupper($request->token);
        $registrationToken = \App\Models\RegistrationToken::where('token', $token)->first();

        if (!$registrationToken || !$registrationToken->isValid()) {
            return back()->withErrors(['token' => 'Token inválido, expirado ou sem usos disponíveis.']);
        }

        return redirect()->route('member.register', ['token' => $token]);
    }

    public function create(Request $request)
    {
        // Check for token in query string or session
        $token = $request->query('token') ?? session('registration_token');
        
        if (!$token) {
            return redirect()->route('member.token-form')
                ->with('error', 'É necessário um token válido para acessar o cadastro de membros.');
        }

        // Validate token
        $registrationToken = \App\Models\RegistrationToken::where('token', strtoupper($token))->first();
        
        if (!$registrationToken || !$registrationToken->isValid()) {
            return redirect()->route('member.token-form')
                ->with('error', 'Token inválido ou expirado.');
        }

        // Store token in session for form submission
        session(['registration_token' => $registrationToken->token]);
        
        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
            
        return view('member-registration', compact('categories', 'registrationToken'));
    }

    public function store(Request $request)
    {
        // Validate token from session
        $token = session('registration_token');
        if (!$token) {
            return redirect()->route('member.token-form')
                ->with('error', 'Token de sessão ausente. Por favor, tente novamente.');
        }

        $registrationToken = \App\Models\RegistrationToken::where('token', $token)->first();
        if (!$registrationToken || !$registrationToken->isValid()) {
            return redirect()->route('member.token-form')
                ->with('error', 'Token inválido ou expirado.');
        }

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
            'commitment_1' => 'required|accepted',
            'commitment_2' => 'required|accepted',
            'commitment_3' => 'required|accepted',
            'commitment_4' => 'required|accepted',
            'commitment_5' => 'required|accepted',
            'how_met' => 'nullable|string',
            'why_join' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'cpf.unique' => 'Este CPF já está cadastrado em nosso sistema.',
            'cpf.regex' => 'O CPF deve estar no formato 000.000.000-00',
            'cpf.size' => 'O CPF deve estar no formato 000.000.000-00',
            'phone.regex' => 'O telefone deve estar no formato (00)99999-9999',
            'phone.size' => 'O telefone deve estar no formato (00)99999-9999',
            'commitment_1.required' => 'Todos os compromissos são obrigatórios.',
            'commitment_1.accepted' => 'Você deve aceitar todos os compromissos para se tornar membro.',
            'commitment_2.required' => 'Todos os compromissos são obrigatórios.',
            'commitment_2.accepted' => 'Você deve aceitar todos os compromissos para se tornar membro.',
            'commitment_3.required' => 'Todos os compromissos são obrigatórios.',
            'commitment_3.accepted' => 'Você deve aceitar todos os compromissos para se tornar membro.',
            'commitment_4.required' => 'Todos os compromissos são obrigatórios.',
            'commitment_4.accepted' => 'Você deve aceitar todos os compromissos para se tornar membro.',
            'commitment_5.required' => 'Todos os compromissos são obrigatórios.',
            'commitment_5.accepted' => 'Você deve aceitar todos os compromissos para se tornar membro.',
            'profile_image.image' => 'O arquivo deve ser uma imagem.',
            'profile_image.mimes' => 'A imagem deve ser do tipo: jpeg, png, jpg ou gif.',
            'profile_image.max' => 'A imagem não pode ser maior que 2MB.',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('member-profiles', 'public');
        }

        $registration = MemberRegistration::create($validated);

        // Increment token usage count
        $registrationToken->incrementUsedCount();

        // Clear token from session
        session()->forget('registration_token');

        return redirect()->route('member.success', ['id' => $registration->id])
            ->with('success', 'Cadastro realizado com sucesso! Você pode baixar o comprovante em PDF.');
    }

    public function success($id)
    {
        $registration = MemberRegistration::findOrFail($id);
        
        $categories = Category::where('is_active', true)
            ->where('show_in_menu', true)
            ->orderBy('order')
            ->get();
            
        return view('member-registration-success', compact('registration', 'categories'));
    }

    public function checkCpf(Request $request)
    {
        $request->validate([
            'cpf' => 'required|string|size:14|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
        ], [
            'cpf.regex' => 'O CPF deve estar no formato 000.000.000-00',
            'cpf.size' => 'O CPF deve estar no formato 000.000.000-00',
        ]);

        $registration = MemberRegistration::where('cpf', $request->cpf)->first();

        if ($registration) {
            return response()->json([
                'exists' => true,
                'data' => [
                    'id' => $registration->id,
                    'full_name' => $registration->full_name,
                    'email' => $registration->email,
                    'parish' => $registration->parish,
                    'status' => $registration->status,
                    'created_at' => $registration->created_at->format('d/m/Y'),
                ],
            ]);
        }

        return response()->json([
            'exists' => false,
            'message' => 'CPF não encontrado em nosso sistema.',
        ]);
    }

    public function downloadPdf($id)
    {
        $registration = MemberRegistration::findOrFail($id);
        
        // Generate PDF with single registration
        $registrations = collect([$registration]);
        $pdf = Pdf::loadView('admin.member-registrations.pdf', compact('registrations'));
        $pdf->setPaper('a4', 'portrait');

        // Generate filename
        $filename = 'cadastro_' . $registration->id . '_' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }
}
