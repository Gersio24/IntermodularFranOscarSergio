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
        Schema::create('rolesUsuarios', function(BluePrint $tabla) {
            $tabla->id();
            $tabla->unsignedBigInteger('id_rol');
            $tabla->unsignedBigInteger('id_usuario');
            $tabla->timestamps();

            $tabla->foreign('id_rol')->references('id')->on('roles')->onDelete('cascade');
            $tabla->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rolesUsuarios');
    }
};
