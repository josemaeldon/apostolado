<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberRegistration;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = MemberRegistration::query();

        // Name search filter
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        // Parish filter
        if ($request->filled('parish')) {
            $query->where('parish', $request->parish);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // City filter
        if ($request->filled('city')) {
            $query->where('member_city', $request->city);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $registrations = $query->latest()->paginate(10)->withQueryString();
        
        // Get unique parishes and cities for filter dropdowns
        $parishes = MemberRegistration::distinct()->pluck('parish')->filter()->sort()->values();
        $cities = MemberRegistration::distinct()->pluck('member_city')->filter()->sort()->values();
        
        return view('admin.member-registrations.index', compact('registrations', 'parishes', 'cities'));
    }

    public function show(MemberRegistration $memberRegistration)
    {
        return view('admin.member-registrations.show', compact('memberRegistration'));
    }

    public function edit(MemberRegistration $memberRegistration)
    {
        return view('admin.member-registrations.edit', compact('memberRegistration'));
    }

    public function update(Request $request, MemberRegistration $memberRegistration)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'full_name' => 'required|string|max:255',
            'cpf' => 'required|string|size:14|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/|unique:member_registrations,cpf,' . $memberRegistration->id,
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'birth_date' => 'required|date',
            'marital_status' => 'required|in:Solteiro(a),Casado(a),Divorciado(a),Viúvo(a)',
            'profession' => 'required|string|max:255',
            'parish' => 'required|string|max:255',
            'member_city' => 'required|string|max:255',
            'member_parish' => 'nullable|string|max:255',
            'baptism_date' => 'nullable|date',
            'how_met' => 'nullable|string',
            'why_join' => 'nullable|string',
        ], [
            'cpf.regex' => 'O CPF deve estar no formato 000.000.000-00',
            'cpf.size' => 'O CPF deve estar no formato 000.000.000-00',
            'cpf.unique' => 'Este CPF já está cadastrado em nosso sistema.',
        ]);

        $memberRegistration->update($validated);

        return redirect()->route('admin.member-registrations.index')
            ->with('success', 'Cadastro atualizado com sucesso!');
    }

    public function destroy(MemberRegistration $memberRegistration)
    {
        $memberRegistration->delete();

        return redirect()->route('admin.member-registrations.index')
            ->with('success', 'Cadastro excluído com sucesso!');
    }

    public function exportPdf(Request $request)
    {
        $query = MemberRegistration::query();

        // Apply same filters as index method
        if ($request->filled('search')) {
            $query->where('full_name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('parish')) {
            $query->where('parish', $request->parish);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('city')) {
            $query->where('member_city', $request->city);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Get all registrations matching the filters (no pagination)
        $registrations = $query->latest()->get();

        // Generate PDF
        $pdf = Pdf::loadView('admin.member-registrations.pdf', compact('registrations'));
        $pdf->setPaper('a4', 'portrait');

        // Generate filename with timestamp
        $filename = 'cadastros_' . now()->format('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
    }
}
