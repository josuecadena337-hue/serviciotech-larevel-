<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TecnicoController;

// ─────────────────────────────────────────────────────────────
// PÁGINA PRINCIPAL (pública)
// ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
})->name('inicio');

Route::get('/servicios', function () {
    return view('servicios');
})->name('servicios');

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
    Route::get('/dashboard',            [ClienteController::class, 'dashboard'])->name('dashboard');
    Route::get('/equipos',              [ClienteController::class, 'misEquipos'])->name('equipos');
    Route::get('/equipos/nuevo',        [ClienteController::class, 'crearEquipo'])->name('equipos.create');
    Route::post('/equipos/nuevo',       [ClienteController::class, 'guardarEquipo'])->name('equipos.store');
    Route::get('/solicitudes',          [ClienteController::class, 'misSolicitudes'])->name('solicitudes');
    Route::get('/solicitudes/nueva',    [ClienteController::class, 'solicitarServicio'])->name('solicitudes.create');
    Route::post('/solicitudes/nueva',   [ClienteController::class, 'guardarSolicitud'])->name('solicitudes.store');
    Route::get('/solicitudes/{id}',     [ClienteController::class, 'verSolicitud'])->name('solicitudes.show');
    Route::get('/citas',                [ClienteController::class, 'misCitas'])->name('citas');
});

// ─────────────────────────────────────────────────────────────
// MÓDULO ADMINISTRADOR
// ─────────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',                        [AdminController::class, 'dashboard'])->name('dashboard');

    // Solicitudes
    Route::get('/solicitudes',                      [AdminController::class, 'solicitudes'])->name('solicitudes');
    Route::get('/solicitudes/{id}',                 [AdminController::class, 'verSolicitud'])->name('solicitudes.show');
    Route::post('/solicitudes/{id}/asignar',        [AdminController::class, 'asignarTecnico'])->name('solicitudes.asignar');
    Route::post('/solicitudes/{id}/cita',           [AdminController::class, 'agendarCita'])->name('solicitudes.cita');
    Route::post('/solicitudes/{id}/estado',         [AdminController::class, 'actualizarEstado'])->name('solicitudes.estado');

    // Usuarios
    Route::get('/usuarios',                         [AdminController::class, 'usuarios'])->name('usuarios');
    Route::post('/tecnicos/{id}/disponibilidad',    [AdminController::class, 'cambiarDisponibilidad'])->name('tecnicos.disponibilidad');
});

// ─────────────────────────────────────────────────────────────
// MÓDULO TÉCNICO
// ─────────────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('tecnico')->name('tecnico.')->group(function () {
    Route::get('/dashboard',                        [TecnicoController::class, 'dashboard'])->name('dashboard');
    Route::get('/asignaciones',                     [TecnicoController::class, 'misAsignaciones'])->name('asignaciones');
    Route::get('/asignaciones/{id}',                [TecnicoController::class, 'verSolicitud'])->name('solicitudes.show');
    Route::post('/asignaciones/{id}/estado',        [TecnicoController::class, 'actualizarEstado'])->name('solicitudes.estado');
    Route::post('/asignaciones/{id}/evidencia',     [TecnicoController::class, 'subirEvidencia'])->name('solicitudes.evidencia');
    Route::get('/citas',                            [TecnicoController::class, 'misCitas'])->name('citas');
});
