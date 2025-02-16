<?php

use App\Http\Controllers\FormularioController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\UsuarioController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/usuarios', [UsuarioController::class, 'index']);

Route::get('/login', [LoginController::class, "showLogin"])->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/formulario', [FormularioController::class, 'index'])->name('formulario');

Route::get('/preguntas', [PreguntasController::class, 'index']);

Route::get('/pregunta/{id}', [PreguntasController::class, 'show']);
