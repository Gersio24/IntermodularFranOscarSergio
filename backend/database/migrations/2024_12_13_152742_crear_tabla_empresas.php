<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('empresas', function(Blueprint $tabla) {
            $tabla->id();
            $tabla->string('nombre');
            $tabla->string('cif')->unique();
            $tabla->string('telefono');
            $tabla->string('email')->unique();
            $tabla->string('direccion_calle');
            $tabla->string('direccion_provincia');
            $tabla->string('poblacion');
            $tabla->float('direccion_lat');
            $tabla->float('direccion_lng');
            $tabla->time('horario_inicio');
            $tabla->time('horario_fin');
            $tabla->string('imagen');
            $tabla->json('categorias');
            $tabla->json('servicios');
            $tabla->json('vacantes_historico');
            $tabla->float('puntuacion_profesor')->default(0);
            $tabla->float('puntuacion_alumno')->default(0);
            $tabla->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
