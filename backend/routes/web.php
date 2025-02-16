<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\EmpresaController;

Route::get('/', function () {
    return view('welcome');
})->name('admin');

Route::resource('usuarios', UserController::class);
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');

Route::get('/login', [LoginController::class, "showLogin"])->name('login');

Route::get('/loginAdmin', [LoginController::class, "log"])->name('log');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/login', [LoginController::class, 'login']);

Route::get('/formulario', [FormularioController::class, 'index'])->name('formulario');

Route::get('/preguntas', [PreguntasController::class, 'index']);

Route::get('/pregunta/{id}', [PreguntasController::class, 'show']);

// Rutas de empresas
Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');

Route::get('/empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');

Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');

Route::get('/empresas/{empresa}', [EmpresaController::class, 'show'])->name('empresas.show');

Route::get('/empresas/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');

Route::put('/empresas/{empresa}', [EmpresaController::class, 'update'])->name('empresas.update');

Route::delete('/empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');
