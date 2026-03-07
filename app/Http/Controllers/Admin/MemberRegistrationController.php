<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberRegistration;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

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

    public function store(Request $request)
    {
        $validated = $request->validate($this->registrationRules());

        // Column is non-nullable in legacy databases; keep empty string when omitted.
        $validated['email'] = $validated['email'] ?? '';

        $this->handleProfileImageUpload($request, $validated);

        MemberRegistration::create($validated);

        return redirect()->route('admin.member-registrations.index')
            ->with('success', 'Novo cadastro criado com sucesso!');
    }

    public function edit(MemberRegistration $memberRegistration)
    {
        return view('admin.member-registrations.edit', compact('memberRegistration'));
    }

    public function update(Request $request, MemberRegistration $memberRegistration)
    {
        // Check if this is a status-only update (from show page)
        // It will have: _token, _method, and status
        $isStatusOnlyUpdate = $request->has('status') && !$request->has('full_name');
        
        if ($isStatusOnlyUpdate) {
            // Validate only the status field
            $validated = $request->validate([
                'status' => 'required|in:pending,approved,rejected',
            ]);
            
            $memberRegistration->update($validated);
            
            return redirect()->route('admin.member-registrations.show', $memberRegistration)
                ->with('success', 'Status atualizado com sucesso!');
        }
        
        // Full validation for complete update (from edit page)
        $validated = $request->validate($this->registrationRules($memberRegistration->id));

        // Column is non-nullable in legacy databases; keep empty string when omitted.
        $validated['email'] = $validated['email'] ?? '';

        $this->handleProfileImageUpload($request, $validated, $memberRegistration);

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

    public function bulkAction(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'parish' => $request->input('parish'),
            'status' => $request->input('filter_status'),
            'city' => $request->input('city'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];

        $validated = $request->validate([
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'integer|exists:member_registrations,id',
            'action' => 'required|in:update_status,delete',
            'status' => 'nullable|in:pending,approved,rejected',
        ], [
            'selected_ids.required' => 'Selecione ao menos um cadastro.',
            'action.required' => 'Selecione uma ação em lote.',
        ]);

        $query = MemberRegistration::whereIn('id', $validated['selected_ids']);

        if ($validated['action'] === 'update_status') {
            $request->validate([
                'status' => 'required|in:pending,approved,rejected',
            ]);

            $updatedCount = $query->update(['status' => $validated['status']]);

            return redirect()->route('admin.member-registrations.index', $filters)
                ->with('success', "Status atualizado para {$updatedCount} cadastro(s).");
        }

        $deletedCount = $query->count();
        $query->delete();

        return redirect()->route('admin.member-registrations.index', $filters)
            ->with('success', "{$deletedCount} cadastro(s) excluído(s) com sucesso.");
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

    private function registrationRules(?int $registrationId = null): array
    {
        return [
            'status' => 'required|in:pending,approved,rejected',
            'full_name' => 'required|string|max:255',
            'cpf' => [
                'required',
                'string',
                'size:14',
                'regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
                Rule::unique('member_registrations', 'cpf')->ignore($registrationId),
            ],
            'email' => 'nullable|email|max:255',
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
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    private function handleProfileImageUpload(Request $request, array &$validated, ?MemberRegistration $memberRegistration = null): void
    {
        if (!$request->hasFile('profile_image')) {
            return;
        }

        if ($memberRegistration?->profile_image) {
            Storage::disk('public')->delete($memberRegistration->profile_image);
        }

        $validated['profile_image'] = $request->file('profile_image')->store('member-profiles', 'public');
    }
}
