<?php

namespace Tests\Feature\Admin;

use App\Models\MemberRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberRegistrationStatusUpdateTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user for authentication
        $this->user = User::factory()->create();
    }

    public function test_can_update_status_from_show_page(): void
    {
        $registration = MemberRegistration::factory()->create([
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('admin.member-registrations.update', $registration), [
                'status' => 'approved',
            ]);

        $response->assertRedirect(route('admin.member-registrations.show', $registration));
        $response->assertSessionHas('success', 'Status atualizado com sucesso!');

        $this->assertDatabaseHas('member_registrations', [
            'id' => $registration->id,
            'status' => 'approved',
        ]);
    }

    public function test_can_update_status_to_rejected(): void
    {
        $registration = MemberRegistration::factory()->create([
            'status' => 'approved',
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('admin.member-registrations.update', $registration), [
                'status' => 'rejected',
            ]);

        $response->assertRedirect(route('admin.member-registrations.show', $registration));

        $this->assertDatabaseHas('member_registrations', [
            'id' => $registration->id,
            'status' => 'rejected',
        ]);
    }

    public function test_cannot_update_with_invalid_status(): void
    {
        $registration = MemberRegistration::factory()->create([
            'status' => 'pending',
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('admin.member-registrations.update', $registration), [
                'status' => 'invalid_status',
            ]);

        $response->assertSessionHasErrors('status');
        
        // Status should remain unchanged
        $this->assertDatabaseHas('member_registrations', [
            'id' => $registration->id,
            'status' => 'pending',
        ]);
    }

    public function test_can_update_full_registration_from_edit_page(): void
    {
        $registration = MemberRegistration::factory()->create([
            'status' => 'pending',
            'full_name' => 'Old Name',
        ]);

        $response = $this->actingAs($this->user)
            ->put(route('admin.member-registrations.update', $registration), [
                'status' => 'approved',
                'full_name' => 'New Name',
                'cpf' => $registration->cpf,
                'email' => $registration->email,
                'phone' => $registration->phone,
                'address' => $registration->address,
                'birth_date' => $registration->birth_date->format('Y-m-d'),
                'marital_status' => $registration->marital_status,
                'profession' => $registration->profession,
                'parish' => $registration->parish,
                'member_city' => $registration->member_city,
                'member_parish' => $registration->member_parish,
                'baptism_date' => $registration->baptism_date?->format('Y-m-d'),
                'how_met' => $registration->how_met,
                'why_join' => $registration->why_join,
            ]);

        $response->assertRedirect(route('admin.member-registrations.index'));
        $response->assertSessionHas('success', 'Cadastro atualizado com sucesso!');

        $this->assertDatabaseHas('member_registrations', [
            'id' => $registration->id,
            'status' => 'approved',
            'full_name' => 'New Name',
        ]);
    }

    public function test_guest_cannot_update_status(): void
    {
        $registration = MemberRegistration::factory()->create([
            'status' => 'pending',
        ]);

        $response = $this->put(route('admin.member-registrations.update', $registration), [
            'status' => 'approved',
        ]);

        $response->assertRedirect(route('login'));
        
        // Status should remain unchanged
        $this->assertDatabaseHas('member_registrations', [
            'id' => $registration->id,
            'status' => 'pending',
        ]);
    }
}
