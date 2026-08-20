<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;

// ─────────────────────────────────────────────────────────────
// PÁGINA PRINCIPAL (pública)
// ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('inicio');

// ─────────────────────────────────────────────────────────────
// AUTENTICACIÓN
// ─────────────────────────────────────────────────────────────
Route::get('/login',     [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/registro',  [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registro']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ─────────────────────────────────────────────────────────────
// MÓDULO CLIENTE
// ─────────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('cliente')->name('cliente.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [ClienteController::class, 'dashboard'])->name('dashboard');

    // Mis Equipos
    Route::get('/equipos',          [ClienteController::class, 'misEquipos'])->name('equipos');
    Route::get('/equipos/nuevo',    [ClienteController::class, 'crearEquipo'])->name('equipos.create');
    Route::post('/equipos/nuevo',   [ClienteController::class, 'guardarEquipo'])->name('equipos.store');

    // Solicitudes de Servicio
    Route::get('/solicitudes',          [ClienteController::class, 'misSolicitudes'])->name('solicitudes');
    Route::get('/solicitudes/nueva',    [ClienteController::class, 'solicitarServicio'])->name('solicitudes.create');
    Route::post('/solicitudes/nueva',   [ClienteController::class, 'guardarSolicitud'])->name('solicitudes.store');
    Route::get('/solicitudes/{id}',     [ClienteController::class, 'verSolicitud'])->name('solicitudes.show');

    // Mis Citas
    Route::get('/citas', [ClienteController::class, 'misCitas'])->name('citas');
});

// ─────────────────────────────────────────────────────────────
// MÓDULO TÉCNICO (temporal)
// ─────────────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/tecnico/dashboard', function () {
        return view('tecnico.dashboard');
    })->name('tecnico.dashboard');
});

// ─────────────────────────────────────────────────────────────
// MÓDULO ADMINISTRADOR (temporal)
// ─────────────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});
