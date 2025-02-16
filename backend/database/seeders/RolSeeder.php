<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Administrador', 'Tutor', 'Centro'];

        foreach ($roles as $nombre) {
            Rol::create(['nombre' => $nombre]);
        }
    }
}
