<?php

namespace Database\Seeders;

use App\Models\Centro;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolSeeder::class);
        $this->call(RolUserSeeder::class);
        $this->call(preguntasSeeder::class);
      
        Empresa::factory(50)->create();
        Centro::factory(20)->create();
        User::factory(50)->create();

        $usu = DB::table('users')->insert([
            'nombre' => 'Paco',
            'NIF' => '64820397A',
            'email' => 'paco@paco.com',
            'password' => bcrypt('1234'),
            'id_centro' => fake()->numberBetween(1, 10),
            'id_empresa' => fake()->numberBetween(1, 10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
