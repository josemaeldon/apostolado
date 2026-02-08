<?php

namespace Database\Factories;

use App\Models\MemberRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MemberRegistration>
 */
class MemberRegistrationFactory extends Factory
{
    protected $model = MemberRegistration::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'parish' => fake()->randomElement(['Paróquia São João', 'Paróquia Santa Maria', 'Paróquia São Paulo']),
            'full_name' => fake()->name(),
            'cpf' => $this->generateCPF(),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'birth_date' => fake()->date('Y-m-d', '-20 years'),
            'marital_status' => fake()->randomElement(['Solteiro(a)', 'Casado(a)', 'Divorciado(a)', 'Viúvo(a)']),
            'profession' => fake()->jobTitle(),
            'member_city' => fake()->city(),
            'member_parish' => fake()->randomElement(['Paróquia Nossa Senhora', 'Paróquia São José', 'Paróquia Santa Teresinha']),
            'baptism_date' => fake()->optional()->date('Y-m-d', '-15 years'),
            'commitment_1' => fake()->boolean(70),
            'commitment_2' => fake()->boolean(70),
            'commitment_3' => fake()->boolean(60),
            'commitment_4' => fake()->boolean(50),
            'commitment_5' => fake()->boolean(60),
            'how_met' => fake()->optional()->sentence(),
            'why_join' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
        ];
    }

    /**
     * Generate a valid CPF format
     */
    private function generateCPF(): string
    {
        $n1 = rand(0, 9);
        $n2 = rand(0, 9);
        $n3 = rand(0, 9);
        $n4 = rand(0, 9);
        $n5 = rand(0, 9);
        $n6 = rand(0, 9);
        $n7 = rand(0, 9);
        $n8 = rand(0, 9);
        $n9 = rand(0, 9);

        $d1 = $n9 * 2 + $n8 * 3 + $n7 * 4 + $n6 * 5 + $n5 * 6 + $n4 * 7 + $n3 * 8 + $n2 * 9 + $n1 * 10;
        $d1 = 11 - ($d1 % 11);
        if ($d1 >= 10) {
            $d1 = 0;
        }

        $d2 = $d1 * 2 + $n9 * 3 + $n8 * 4 + $n7 * 5 + $n6 * 6 + $n5 * 7 + $n4 * 8 + $n3 * 9 + $n2 * 10 + $n1 * 11;
        $d2 = 11 - ($d2 % 11);
        if ($d2 >= 10) {
            $d2 = 0;
        }

        return sprintf('%d%d%d.%d%d%d.%d%d%d-%d%d', $n1, $n2, $n3, $n4, $n5, $n6, $n7, $n8, $n9, $d1, $d2);
    }

    /**
     * Indicate that the registration is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }

    /**
     * Indicate that the registration is approved.
     */
    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'approved',
        ]);
    }

    /**
     * Indicate that the registration is rejected.
     */
    public function rejected(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'rejected',
        ]);
    }
}
