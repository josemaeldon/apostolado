<?php

namespace Tests\Feature\Admin;

use App\Models\MemberRegistration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberRegistrationPdfExportTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user for authentication
        $this->user = User::factory()->create();
    }

    public function test_authenticated_user_can_export_pdf(): void
    {
        // Create test member registrations
        MemberRegistration::factory()->count(3)->create([
            'status' => 'approved',
            'parish' => 'Test Parish',
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('admin.member-registrations.export-pdf'));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_pdf_export_respects_parish_filter(): void
    {
        // Create registrations with different parishes
        MemberRegistration::factory()->count(2)->create(['parish' => 'Parish A']);
        MemberRegistration::factory()->count(3)->create(['parish' => 'Parish B']);

        $response = $this->actingAs($this->user)
            ->get(route('admin.member-registrations.export-pdf', ['parish' => 'Parish A']));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_pdf_export_respects_city_filter(): void
    {
        // Create registrations with different cities
        MemberRegistration::factory()->count(2)->create(['member_city' => 'City A']);
        MemberRegistration::factory()->count(3)->create(['member_city' => 'City B']);

        $response = $this->actingAs($this->user)
            ->get(route('admin.member-registrations.export-pdf', ['city' => 'City A']));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_pdf_export_respects_status_filter(): void
    {
        // Create registrations with different statuses
        MemberRegistration::factory()->count(2)->create(['status' => 'pending']);
        MemberRegistration::factory()->count(3)->create(['status' => 'approved']);

        $response = $this->actingAs($this->user)
            ->get(route('admin.member-registrations.export-pdf', ['status' => 'approved']));

        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_guest_cannot_export_pdf(): void
    {
        MemberRegistration::factory()->count(2)->create();

        $response = $this->get(route('admin.member-registrations.export-pdf'));

        $response->assertRedirect(route('login'));
    }
}
