<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\CentroController;

Route::middleware(['auth', 'checkRol:Administrador'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('admin');

    Route::resource('usuarios', UserController::class);
    Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios');

    Route::resource('formularios', FormularioController::class);

    Route::get('/formulario', [FormularioController::class, 'index'])->name('formulario');

    Route::get('/preguntas', [PreguntasController::class, 'index']);

    Route::get('/pregunta/{id}', [PreguntasController::class, 'show']);

    Route::get('/empresas', [EmpresaController::class, 'index'])->name('empresas.index');

    Route::get('/empresas/create', [EmpresaController::class, 'create'])->name('empresas.create');

    Route::post('/empresas', [EmpresaController::class, 'store'])->name('empresas.store');

    Route::get('/empresas/{empresa}', [EmpresaController::class, 'show'])->name('empresas.show');

    Route::get('/empresas/{empresa}/edit', [EmpresaController::class, 'edit'])->name('empresas.edit');

    Route::put('/empresas/{empresa}', [EmpresaController::class, 'update'])->name('empresas.update');

    Route::delete('/empresas/{empresa}', [EmpresaController::class, 'destroy'])->name('empresas.destroy');

    Route::get('/centros', [CentroController::class, 'index'])->name('centros.index');

    Route::get('/centros/create', [CentroController::class, 'create'])->name('centros.create');

    Route::post('/centros', [CentroController::class, 'store'])->name('centros.store');

    Route::get('/centros/{centro}', [CentroController::class, 'show'])->name('centros.show');

    Route::get('/centros/{centro}/edit', [CentroController::class, 'edit'])->name('centros.edit');

    Route::put('/centros/{centro}', [CentroController::class, 'update'])->name('centros.update');

    Route::delete('/centros/{centro}', [CentroController::class, 'destroy'])->name('centros.destroy');

});

Route::withoutMiddleware(['auth', 'checkRol:Administrador'])->group(function () {
    Route::get('/login', [LoginController::class, "showLogin"])->name('login');

    Route::get('/loginAdmin', [LoginController::class, "log"])->name('log');

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/login', [LoginController::class, 'login']);
});

