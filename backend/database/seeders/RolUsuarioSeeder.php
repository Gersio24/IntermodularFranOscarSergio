<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Rol;

class RolUsuarioSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Rol::all();

        Usuario::all()->each(function ($usuario) use ($roles) {
            $rolesAleatorios = $roles->random(rand(1, 3))->pluck('id');
            $usuario->roles()->attach($rolesAleatorios);
        });
    }
}

