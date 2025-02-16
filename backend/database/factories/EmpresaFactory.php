<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'cif' => $this->faker->unique()->bothify('B########'),
            'telefono' => $this->faker->phoneNumber(),
            'email' => $this->faker->unique()->companyEmail(),
            'direccion_calle' => $this->faker->streetAddress(),
            'direccion_provincia' => $this->faker->state(),
            'poblacion' => $this->faker->city(),
            'direccion_lat' => $this->faker->latitude(),
            'direccion_lng' => $this->faker->longitude(),
            'horario_inicio' => '08:00',
            'horario_fin' => '18:00',
            'imagen' => $this->faker->imageUrl(300, 180),
            'categorias' => $this->faker->randomElements([
                'Administración de sistemas',
                'Administración de empresas',
                'Programación web'
            ], rand(1, 3)),
            'servicios' => $this->faker->randomElements([
                'Linux', 'Cisco', 'Windows', 'Personal', 'Frontend',
                'Backend', 'Angular', 'React', 'Vue'
            ], rand(3, 9)),
            'vacantes_historico' => [
                ['year' => 2021, 'count' => rand(1, 10)],
                ['year' => 2022, 'count' => rand(1, 10)],
                ['year' => 2023, 'count' => rand(1, 10)],
                ['year' => 2024, 'count' => rand(1, 10)]
            ],
            'puntuacion_profesor' => $this->faker->randomFloat(2, 0, 100),
            'puntuacion_alumno' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
