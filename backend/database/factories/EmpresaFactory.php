<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresa>
 */
class EmpresaFactory extends Factory
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
            'cif' => $this->faker->unique()->bothify('A########'), // Simulación de un CIF
            'descripcion' => $this->faker->sentence(),
            'imagen' => $this->faker->imageUrl(640, 480, 'business'), // URL de imagen aleatoria
            'notas' => $this->faker->paragraph(),
            'email' => $this->faker->unique()->safeEmail(),
            'direccion_calle' => $this->faker->streetAddress(),
            'direccion_provincia' => $this->faker->state(),
            'direccion_lat' => $this->faker->latitude(),
            'direccion_log' => $this->faker->longitude(),
            'provincia' => $this->faker->state(),
            'poblacion' => $this->faker->city(),
            'vacantes' => $this->faker->numberBetween(1, 10),
            'horario_inicio' => $this->faker->time('H:i'),
            'horario_fin' => $this->faker->time('H:i'),
            'password' => $this->faker->password(), // Contraseña encriptada
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
