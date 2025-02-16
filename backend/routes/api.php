<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\Api\EmpresaController;
use App\Http\Controllers\FormularioController;


Route::withoutMiddleware(['auth', 'checkRol:Administrador'])->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Añadir ruta para obtener empresas
    Route::get('/empresas', [EmpresaController::class, 'index']);
    Route::get('/empresas/{id}', [EmpresaController::class, 'show']);
    Route::post('/empresas', [EmpresaController::class, 'store']);
    Route::put('/empresas/{id}', [EmpresaController::class, 'update']);
    Route::delete('/empresas/{id}', [EmpresaController::class, 'destroy']);
});

Route::middleware(['auth', 'checkRol:Administrador'])->group(function () {
    Route::get('/', function () {
        return redirect('/');
    });
});

Route::middleware('api')->group(function () {
    Route::get('form/preguntas/{token}', [FormularioController::class, 'getPreguntasByToken']);
    
    Route::prefix('form')->group(function () {
        Route::get('preguntas/{token}', [FormularioController::class, 'getPreguntasByToken']);
    });

    Route::post('form/respuestas/{token}', [FormularioController::class, 'submitAnswers']);
});

