<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TecnicoController;

// =====================================================================
// RUTAS PÚBLICAS
// =====================================================================
// Estas rutas son las que puede ver cualquier persona que entre a la página,
// sin necesidad de iniciar sesión o tener una cuenta.

Route::get('/', function () {
    return view('welcome');
})->name('inicio');

Route::get('/servicios', function () {
    return view('servicios');
})->name('servicios');

Route::get('/multimedia', function () {
    return view('multimedia');
})->name('multimedia');

Route::get('/contacto', function () {
    return view('contacto');
})->name('contacto');

// =====================================================================
// RUTAS DE AUTENTICACIÓN (LOGIN Y REGISTRO)
// =====================================================================
// Aquí manejamos el inicio de sesión, el registro de nuevos usuarios
// y también el cierre de sesión (logout).

Route::get('/login',     [AuthController::class, 'mostrarLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/registro',  [AuthController::class, 'mostrarRegistro'])->name('registro');
Route::post('/registro', [AuthController::class, 'registro']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// =====================================================================
// RUTAS DEL CLIENTE
// =====================================================================
// Solo los usuarios que iniciaron sesión (auth) pueden acceder aquí.
// El "prefix('cliente')" significa que todas estas rutas empezarán con /cliente/
// Por ejemplo: /cliente/dashboard

Route::middleware(['auth'])->prefix('cliente')->name('cliente.')->group(function () {
    // Pantalla de inicio del cliente
    Route::get('/dashboard',            [ClienteController::class, 'dashboard'])->name('dashboard');
    
    // Gestión de sus electrodomésticos (Neveras, lavadoras, etc)
    Route::get('/equipos',              [ClienteController::class, 'misEquipos'])->name('equipos');
    Route::get('/equipos/nuevo',        [ClienteController::class, 'crearEquipo'])->name('equipos.create');
    Route::post('/equipos/nuevo',       [ClienteController::class, 'guardarEquipo'])->name('equipos.store');
    
    // Solicitudes de servicio (para pedir que le reparen algo)
    Route::get('/solicitudes',          [ClienteController::class, 'misSolicitudes'])->name('solicitudes');
    Route::get('/solicitudes/nueva',    [ClienteController::class, 'solicitarServicio'])->name('solicitudes.create');
    Route::post('/solicitudes/nueva',   [ClienteController::class, 'guardarSolicitud'])->name('solicitudes.store');
    Route::get('/solicitudes/{id}',     [ClienteController::class, 'verSolicitud'])->name('solicitudes.show');
    
    // Ver citas programadas con el técnico
    Route::get('/citas',                [ClienteController::class, 'misCitas'])->name('citas');
});

// =====================================================================
// RUTAS DEL ADMINISTRADOR
// =====================================================================
// Rutas exclusivas para el jefe o administrador del sistema.
// Todas empiezan con /admin/

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Pantalla de inicio del administrador
    Route::get('/dashboard',                        [AdminController::class, 'dashboard'])->name('dashboard');

    // Aquí el admin puede ver y gestionar todas las solicitudes de todos los clientes
    Route::get('/solicitudes',                      [AdminController::class, 'solicitudes'])->name('solicitudes');
    Route::get('/solicitudes/{id}',                 [AdminController::class, 'verSolicitud'])->name('solicitudes.show');
    
    // Acciones importantes: asignar qué técnico hará el trabajo, programar cita y cambiar el estado
    Route::post('/solicitudes/{id}/asignar',        [AdminController::class, 'asignarTecnico'])->name('solicitudes.asignar');
    Route::post('/solicitudes/{id}/cita',           [AdminController::class, 'agendarCita'])->name('solicitudes.cita');
    Route::post('/solicitudes/{id}/estado',         [AdminController::class, 'actualizarEstado'])->name('solicitudes.estado');

    // Gestión de usuarios y cambiar si un técnico está disponible o no
    Route::get('/usuarios',                         [AdminController::class, 'usuarios'])->name('usuarios');
    Route::post('/tecnicos/{id}/disponibilidad',    [AdminController::class, 'cambiarDisponibilidad'])->name('tecnicos.disponibilidad');
});

// =====================================================================
// RUTAS DEL TÉCNICO
// =====================================================================
// Rutas para que los técnicos vean su trabajo pendiente. Empiezan con /tecnico/

Route::middleware(['auth'])->prefix('tecnico')->name('tecnico.')->group(function () {
    // Pantalla de inicio del técnico
    Route::get('/dashboard',                        [TecnicoController::class, 'dashboard'])->name('dashboard');
    
    // Ver los trabajos que el administrador le asignó a este técnico
    Route::get('/asignaciones',                     [TecnicoController::class, 'misAsignaciones'])->name('asignaciones');
    Route::get('/asignaciones/{id}',                [TecnicoController::class, 'verSolicitud'])->name('solicitudes.show');
    
    // El técnico usa esto para actualizar cómo va el trabajo y subir pruebas (fotos del arreglo)
    Route::post('/asignaciones/{id}/estado',        [TecnicoController::class, 'actualizarEstado'])->name('solicitudes.estado');
    Route::post('/asignaciones/{id}/evidencia',     [TecnicoController::class, 'subirEvidencia'])->name('solicitudes.evidencia');
    
    // Ver las citas que el técnico tiene programadas en su agenda
    Route::get('/citas',                            [TecnicoController::class, 'misCitas'])->name('citas');
});
