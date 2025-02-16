<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Centro>
 */
class CentroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->company(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->password(), // Contraseña encriptada
            'direccion' => $this->faker->address(),
            'telefono' => $this->faker->phoneNumber(),
            'poblacion' => $this->faker->city(),
            'provincia' => $this->faker->state(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
