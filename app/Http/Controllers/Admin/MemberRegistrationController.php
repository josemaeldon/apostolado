<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberRegistration;
use Illuminate\Http\Request;

class MemberRegistrationController extends Controller
{
    public function index()
    {
        $registrations = MemberRegistration::latest()->paginate(10);
        return view('admin.member-registrations.index', compact('registrations'));
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
