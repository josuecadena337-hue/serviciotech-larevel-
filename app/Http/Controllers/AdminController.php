<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitud;
use App\Models\Usuario;
use App\Models\Tecnico;
use App\Models\Cliente;
use App\Models\Asignacion;
use App\Models\Cita;
use App\Models\Rol;

class AdminController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // DASHBOARD — Estadísticas globales del sistema
    // ─────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $totalClientes   = Cliente::count();
        $totalTecnicos   = Tecnico::count();
        $totalSolicitudes = Solicitud::count();
        $pendientes      = Solicitud::where('estado_solicitud', 'pendiente')->count();
        $enProceso       = Solicitud::where('estado_solicitud', 'en_proceso')->count();
        $completadas     = Solicitud::where('estado_solicitud', 'completada')->count();

        // Últimas 5 solicitudes
        $ultimasSolicitudes = Solicitud::with(['cliente.usuario', 'electrodomestico', 'categoriaFalla'])
            ->latest()
            ->take(5)
            ->get();

        // Técnicos disponibles
        $tecnicosDisponibles = Tecnico::where('disponibilidad', 'disponible')
            ->with('usuario')
            ->get();

        return view('admin.dashboard', compact(
            'totalClientes', 'totalTecnicos', 'totalSolicitudes',
            'pendientes', 'enProceso', 'completadas',
            'ultimasSolicitudes', 'tecnicosDisponibles'
        ));
    }

    // ─────────────────────────────────────────────────────────────
    // TODAS LAS SOLICITUDES — Lista completa con filtros
    // ─────────────────────────────────────────────────────────────
    public function solicitudes(Request $request)
    {
        $query = Solicitud::with(['cliente.usuario', 'electrodomestico', 'categoriaFalla', 'asignaciones.tecnico.usuario']);

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado_solicitud', $request->estado);
        }

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('tipo_solicitud', $request->tipo);
        }

        $solicitudes = $query->latest()->get();

        return view('admin.solicitudes.index', compact('solicitudes'));
    }

    // ─────────────────────────────────────────────────────────────
    // VER SOLICITUD — Detalle con opciones de gestión
    // ─────────────────────────────────────────────────────────────
    public function verSolicitud($id)
    {
        $solicitud = Solicitud::with([
            'cliente.usuario',
            'electrodomestico',
            'categoriaFalla',
            'asignaciones.tecnico.usuario',
            'citas.tecnico.usuario',
            'evidencias.usuario',
        ])->findOrFail($id);

        $tecnicos = Tecnico::with('usuario')->get();

        return view('admin.solicitudes.show', compact('solicitud', 'tecnicos'));
    }

    // ─────────────────────────────────────────────────────────────
    // ASIGNAR TÉCNICO — Asigna un técnico a la solicitud
    // ─────────────────────────────────────────────────────────────
    public function asignarTecnico(Request $request, $id)
    {
        $request->validate([
            'id_tecnico' => 'required|exists:tecnicos,id_usuario',
        ], [
            'id_tecnico.required' => 'Selecciona un técnico.',
        ]);

        $solicitud = Solicitud::findOrFail($id);
        $admin     = Auth::user()->administrador;

        // Cancelar asignaciones activas previas
        Asignacion::where('id_solicitud', $id)
            ->where('estado', 'activa')
            ->update(['estado' => 'reasignada']);

        // Crear nueva asignación
        Asignacion::create([
            'id_solicitud' => $id,
            'id_tecnico'   => $request->id_tecnico,
            'id_admin'     => $admin->id_usuario,
            'estado'       => 'activa',
        ]);

        // Actualizar estado de la solicitud
        $solicitud->update(['estado_solicitud' => 'asignada']);

        return redirect()->route('admin.solicitudes.show', $id)
            ->with('success', '¡Técnico asignado correctamente!');
    }

    // ─────────────────────────────────────────────────────────────
    // AGENDAR CITA — Programa fecha y hora para el servicio
    // ─────────────────────────────────────────────────────────────
    public function agendarCita(Request $request, $id)
    {
        $request->validate([
            'fecha'      => 'required|date|after_or_equal:today',
            'hora'       => 'required',
            'id_tecnico' => 'required|exists:tecnicos,id_usuario',
        ], [
            'fecha.required'      => 'La fecha es obligatoria.',
            'fecha.after_or_equal'=> 'La fecha debe ser hoy o en el futuro.',
            'hora.required'       => 'La hora es obligatoria.',
            'id_tecnico.required' => 'Selecciona el técnico para la cita.',
        ]);

        Cita::create([
            'fecha'        => $request->fecha,
            'hora'         => $request->hora,
            'estado'       => 'confirmada',
            'id_solicitud' => $id,
            'id_tecnico'   => $request->id_tecnico,
        ]);

        // Actualizar estado de la solicitud
        Solicitud::findOrFail($id)->update(['estado_solicitud' => 'agendada']);

        return redirect()->route('admin.solicitudes.show', $id)
            ->with('success', '¡Cita agendada correctamente!');
    }

    // ─────────────────────────────────────────────────────────────
    // ACTUALIZAR ESTADO — Cambia el estado de una solicitud
    // ─────────────────────────────────────────────────────────────
    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'estado_solicitud' => 'required|in:pendiente,asignada,agendada,en_proceso,completada,cancelada',
        ]);

        Solicitud::findOrFail($id)->update([
            'estado_solicitud' => $request->estado_solicitud,
        ]);

        return redirect()->route('admin.solicitudes.show', $id)
            ->with('success', 'Estado actualizado correctamente.');
    }

    // ─────────────────────────────────────────────────────────────
    // GESTIONAR USUARIOS — Lista de clientes y técnicos
    // ─────────────────────────────────────────────────────────────
    public function usuarios()
    {
        $clientes  = Cliente::with('usuario')->get();
        $tecnicos  = Tecnico::with('usuario')->get();

        return view('admin.usuarios.index', compact('clientes', 'tecnicos'));
    }

    // ─────────────────────────────────────────────────────────────
    // CAMBIAR DISPONIBILIDAD TÉCNICO
    // ─────────────────────────────────────────────────────────────
    public function cambiarDisponibilidad(Request $request, $id)
    {
        $request->validate([
            'disponibilidad' => 'required|in:disponible,ocupado,inactivo',
        ]);

        Tecnico::where('id_usuario', $id)->update([
            'disponibilidad' => $request->disponibilidad,
        ]);

        return redirect()->route('admin.usuarios')
            ->with('success', 'Disponibilidad del técnico actualizada.');
    }
}
