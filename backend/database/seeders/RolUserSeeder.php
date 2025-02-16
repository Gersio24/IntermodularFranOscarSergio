<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rol;

class RolUserSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Rol::all();

        User::all()->each(function ($usuario) use ($roles) {
            $rolesAleatorios = $roles->random(rand(1, 3))->pluck('id');
            $usuario->roles()->attach($rolesAleatorios);
        });
    }
}

