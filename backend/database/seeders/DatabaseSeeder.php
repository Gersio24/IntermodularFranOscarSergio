<?php

namespace Database\Seeders;

use App\Models\Centro;
use App\Models\Empresa;
use App\Models\Usuario;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

<<<<<<< HEAD
        $this->call(preguntasSeeder::class);
=======
        Empresa::factory(10)->create();
        Centro::factory(10)->create();
        Usuario::factory(50)->create();
>>>>>>> 7257daeda0c7e776a0d11fcb15b8185eb924e55c
    }
}
