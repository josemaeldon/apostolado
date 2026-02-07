<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberRegistration;
use Illuminate\Http\Request;

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

    public function update(Request $request, MemberRegistration $memberRegistration)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $memberRegistration->update($validated);

        return redirect()->route('admin.member-registrations.show', $memberRegistration)
            ->with('success', 'Status atualizado com sucesso!');
    }

    public function destroy(MemberRegistration $memberRegistration)
    {
        $memberRegistration->delete();

        return redirect()->route('admin.member-registrations.index')
            ->with('success', 'Cadastro excluído com sucesso!');
    }
}
