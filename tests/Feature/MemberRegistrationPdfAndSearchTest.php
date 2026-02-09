<?php

namespace Tests\Feature;

use App\Models\MemberRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberRegistrationPdfAndSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_registration_redirects_to_success_page(): void
    {
        $data = [
            'parish' => 'Test Parish',
            'full_name' => 'John Doe',
            'cpf' => '123.456.789-00',
            'address' => 'Test Address',
            'phone' => '(11)98765-4321',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
            'marital_status' => 'Solteiro(a)',
            'profession' => 'Developer',
            'member_city' => 'São Paulo',
            'member_parish' => 'Test Parish',
            'commitment_1' => '1',
            'commitment_2' => '1',
            'commitment_3' => '1',
            'commitment_4' => '1',
            'commitment_5' => '1',
        ];

        $response = $this->post(route('member.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseHas('member_registrations', [
            'cpf' => '123.456.789-00',
            'full_name' => 'John Doe',
        ]);
        
        $registration = MemberRegistration::where('cpf', '123.456.789-00')->first();
        $response->assertRedirect(route('member.success', $registration->id));
    }

    public function test_success_page_displays_registration_details(): void
    {
        $this->withoutVite();
        
        $registration = MemberRegistration::create([
            'parish' => 'Test Parish',
            'full_name' => 'John Doe',
            'cpf' => '123.456.789-00',
            'address' => 'Test Address',
            'phone' => '(11)98765-4321',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
            'marital_status' => 'Solteiro(a)',
            'profession' => 'Developer',
            'member_city' => 'São Paulo',
            'member_parish' => 'Test Parish',
            'status' => 'pending',
        ]);

        $response = $this->get(route('member.success', $registration->id));

        $response->assertOk();
        $response->assertSee('John Doe');
        $response->assertSee('john@example.com');
        $response->assertSee('Test Parish');
        $response->assertSee('Baixar Comprovante');
    }

    public function test_can_download_registration_pdf(): void
    {
        $registration = MemberRegistration::create([
            'parish' => 'Test Parish',
            'full_name' => 'John Doe',
            'cpf' => '123.456.789-00',
            'address' => 'Test Address',
            'phone' => '(11)98765-4321',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
            'marital_status' => 'Solteiro(a)',
            'profession' => 'Developer',
            'member_city' => 'São Paulo',
            'member_parish' => 'Test Parish',
            'status' => 'pending',
        ]);

        $response = $this->get(route('member.download-pdf', $registration->id));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
    }

    public function test_cpf_search_finds_existing_registration(): void
    {
        $registration = MemberRegistration::create([
            'parish' => 'Test Parish',
            'full_name' => 'John Doe',
            'cpf' => '123.456.789-00',
            'address' => 'Test Address',
            'phone' => '(11)98765-4321',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
            'marital_status' => 'Solteiro(a)',
            'profession' => 'Developer',
            'member_city' => 'São Paulo',
            'member_parish' => 'Test Parish',
            'status' => 'pending',
        ]);

        $response = $this->postJson(route('member.check-cpf'), [
            'cpf' => '123.456.789-00',
        ]);

        $response->assertOk();
        $response->assertJson([
            'exists' => true,
            'data' => [
                'full_name' => 'John Doe',
                'email' => 'john@example.com',
                'parish' => 'Test Parish',
                'status' => 'pending',
            ],
        ]);
    }

    public function test_cpf_search_returns_not_found_for_non_existing_cpf(): void
    {
        $response = $this->postJson(route('member.check-cpf'), [
            'cpf' => '999.999.999-99',
        ]);

        $response->assertOk();
        $response->assertJson([
            'exists' => false,
            'message' => 'CPF não encontrado em nosso sistema.',
        ]);
    }

    public function test_cpf_search_validates_cpf_format(): void
    {
        $response = $this->postJson(route('member.check-cpf'), [
            'cpf' => '12345',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('cpf');
    }

    public function test_duplicate_cpf_cannot_be_registered(): void
    {
        MemberRegistration::create([
            'parish' => 'Test Parish',
            'full_name' => 'John Doe',
            'cpf' => '123.456.789-00',
            'address' => 'Test Address',
            'phone' => '(11)98765-4321',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
            'marital_status' => 'Solteiro(a)',
            'profession' => 'Developer',
            'member_city' => 'São Paulo',
            'member_parish' => 'Test Parish',
        ]);

        $response = $this->post(route('member.store'), [
            'parish' => 'Another Parish',
            'full_name' => 'Jane Doe',
            'cpf' => '123.456.789-00',  // Same CPF
            'address' => 'Another Address',
            'phone' => '(11)98765-4322',
            'email' => 'jane@example.com',
            'birth_date' => '1991-01-01',
            'marital_status' => 'Solteiro(a)',
            'profession' => 'Designer',
            'member_city' => 'Rio de Janeiro',
            'member_parish' => 'Another Parish',
            'commitment_1' => '1',
            'commitment_2' => '1',
            'commitment_3' => '1',
            'commitment_4' => '1',
            'commitment_5' => '1',
        ]);

        $response->assertSessionHasErrors('cpf');
    }

    public function test_all_commitments_are_required(): void
    {
        $baseData = [
            'parish' => 'Test Parish',
            'full_name' => 'John Doe',
            'cpf' => '123.456.789-00',
            'address' => 'Test Address',
            'phone' => '(11)98765-4321',
            'email' => 'john@example.com',
            'birth_date' => '1990-01-01',
            'marital_status' => 'Solteiro(a)',
            'profession' => 'Developer',
            'member_city' => 'São Paulo',
            'member_parish' => 'Test Parish',
        ];

        // Test without any commitments
        $response = $this->post(route('member.store'), $baseData);
        $response->assertSessionHasErrors(['commitment_1', 'commitment_2', 'commitment_3', 'commitment_4', 'commitment_5']);

        // Test with only some commitments
        $response = $this->post(route('member.store'), array_merge($baseData, [
            'commitment_1' => '1',
            'commitment_2' => '1',
            // Missing 3, 4, 5
        ]));
        $response->assertSessionHasErrors(['commitment_3', 'commitment_4', 'commitment_5']);

        // Test with all commitments - should succeed
        $response = $this->post(route('member.store'), array_merge($baseData, [
            'commitment_1' => '1',
            'commitment_2' => '1',
            'commitment_3' => '1',
            'commitment_4' => '1',
            'commitment_5' => '1',
        ]));
        $response->assertRedirect();
        $this->assertDatabaseHas('member_registrations', [
            'cpf' => '123.456.789-00',
        ]);
    }
}
