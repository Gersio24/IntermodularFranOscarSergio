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
        Schema::create('resenyas', function(BluePrint $tabla) {
            $tabla->id();
            $tabla->date('fecha_resena');
            $tabla->string('valoracion');
            $tabla->unsignedBigInteger('id_pregunta_formulario');
            $tabla->timestamps();

            $tabla->foreign('id_pregunta_formulario')->references('id')->on('preguntaFormulario')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resenyas');
    }
};
