<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MemberRegistration;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class MemberRegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $query = MemberRegistration::query();

        // Apply filters
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

        // Pagination
        $perPage = $request->input('per_page', 15);
        $registrations = $query->latest()->paginate($perPage);

        return response()->json($registrations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'parish' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'cpf' => 'required|string|size:14|unique:member_registrations,cpf|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'birth_date' => 'required|date',
            'marital_status' => 'required|in:Solteiro(a),Casado(a),Divorciado(a),Viúvo(a)',
            'profession' => 'required|string|max:255',
            'member_city' => 'required|string|max:255',
            'member_parish' => 'nullable|string|max:255',
            'baptism_date' => 'nullable|date',
            'commitment_1' => 'boolean',
            'commitment_2' => 'boolean',
            'commitment_3' => 'boolean',
            'commitment_4' => 'boolean',
            'commitment_5' => 'boolean',
            'how_met' => 'nullable|string',
            'why_join' => 'nullable|string',
            'status' => 'nullable|in:pending,approved,rejected',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('member-profiles', 'public');
        }

        // Set default status if not provided
        $validated['status'] = $validated['status'] ?? 'pending';

        $registration = MemberRegistration::create($validated);

        return response()->json([
            'message' => 'Cadastro criado com sucesso',
            'data' => $registration
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(MemberRegistration $memberRegistration): JsonResponse
    {
        return response()->json($memberRegistration);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MemberRegistration $memberRegistration): JsonResponse
    {
        $validated = $request->validate([
            'parish' => 'sometimes|required|string|max:255',
            'full_name' => 'sometimes|required|string|max:255',
            'cpf' => 'sometimes|required|string|size:14|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/|unique:member_registrations,cpf,' . $memberRegistration->id,
            'address' => 'sometimes|required|string',
            'phone' => 'sometimes|required|string|max:20',
            'email' => 'sometimes|required|email|max:255',
            'birth_date' => 'sometimes|required|date',
            'marital_status' => 'sometimes|required|in:Solteiro(a),Casado(a),Divorciado(a),Viúvo(a)',
            'profession' => 'sometimes|required|string|max:255',
            'member_city' => 'sometimes|required|string|max:255',
            'member_parish' => 'nullable|string|max:255',
            'baptism_date' => 'nullable|date',
            'commitment_1' => 'boolean',
            'commitment_2' => 'boolean',
            'commitment_3' => 'boolean',
            'commitment_4' => 'boolean',
            'commitment_5' => 'boolean',
            'how_met' => 'nullable|string',
            'why_join' => 'nullable|string',
            'status' => 'sometimes|in:pending,approved,rejected',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($memberRegistration->profile_image) {
                Storage::disk('public')->delete($memberRegistration->profile_image);
            }
            $validated['profile_image'] = $request->file('profile_image')->store('member-profiles', 'public');
        }

        $memberRegistration->update($validated);

        return response()->json([
            'message' => 'Cadastro atualizado com sucesso',
            'data' => $memberRegistration
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberRegistration $memberRegistration): JsonResponse
    {
        // Delete profile image if exists
        if ($memberRegistration->profile_image) {
            Storage::disk('public')->delete($memberRegistration->profile_image);
        }

        $memberRegistration->delete();

        return response()->json([
            'message' => 'Cadastro excluído com sucesso'
        ]);
    }
}
