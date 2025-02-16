<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Usuario;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company(),
            'NIF' => $this->faker->bothify('########?'),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'id_centro' => $this->faker->numberBetween(1, 10),
            'id_empresa' => $this->faker->numberBetween(1, 10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
