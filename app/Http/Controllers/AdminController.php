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
    // =====================================================================
    // 1. PANTALLA PRINCIPAL DEL ADMINISTRADOR (DASHBOARD)
    // =====================================================================
    // Aquí preparamos el resumen global de cómo va el negocio: 
    // totales de clientes, técnicos, cuántos trabajos hay pendientes, etc.
    public function dashboard()
    {
        // Contamos cuántas personas y trabajos hay en total en todo el sistema
        $totalClientes    = Cliente::count();
        $totalTecnicos    = Tecnico::count();
        $totalSolicitudes = Solicitud::count();
        
        // Vemos cómo están los trabajos según su estado
        $pendientes  = Solicitud::where('estado_solicitud', 'pendiente')->count();
        $enProceso   = Solicitud::where('estado_solicitud', 'en_proceso')->count();
        $completadas = Solicitud::where('estado_solicitud', 'completada')->count();

        // Traemos las últimas 5 peticiones que hicieron los clientes para verlas rápido
        $ultimasSolicitudes = Solicitud::with(['cliente.usuario', 'electrodomestico', 'categoriaFalla'])
            ->latest()
            ->take(5)
            ->get();

        // Vemos qué técnicos están libres para poder asignarles trabajo
        $tecnicosDisponibles = Tecnico::where('disponibilidad', 'disponible')
            ->with('usuario')
            ->get();

        // Mandamos todos estos datos a la vista del dashboard
        return view('admin.dashboard', compact(
            'totalClientes', 'totalTecnicos', 'totalSolicitudes',
            'pendientes', 'enProceso', 'completadas',
            'ultimasSolicitudes', 'tecnicosDisponibles'
        ));
    }

    // =====================================================================
    // 2. VER TODAS LAS SOLICITUDES DEL SISTEMA
    // =====================================================================
    // Esta función muestra la lista completa de todas las peticiones de 
    // reparación que han hecho todos los clientes.
    public function solicitudes(Request $request)
    {
        // Empezamos preparando la búsqueda con toda la información relacionada (cliente, equipo, técnico)
        $query = Solicitud::with(['cliente.usuario', 'electrodomestico', 'categoriaFalla', 'asignaciones.tecnico.usuario']);

        // Si el admin usó el filtro de "Estado" (ej: ver solo las completadas), lo aplicamos
        if ($request->filled('estado')) {
            $query->where('estado_solicitud', $request->estado);
        }

        // Si usó el filtro de "Tipo" (ej: ver solo mantenimiento preventivo), lo aplicamos
        if ($request->filled('tipo')) {
            $query->where('tipo_solicitud', $request->tipo);
        }

        // Ejecutamos la búsqueda ordenando de la más nueva a la más vieja
        $solicitudes = $query->latest()->get();

        // Mostramos la lista en pantalla
        return view('admin.solicitudes.index', compact('solicitudes'));
    }

    // =====================================================================
    // 3. VER TODOS LOS DETALLES DE UNA SOLICITUD ESPECÍFICA
    // =====================================================================
    public function verSolicitud($id)
    {
        // Buscamos una solicitud en particular y traemos absolutamente toda su historia:
        // quién es el cliente, qué aparato es, qué técnico tiene asignado, sus citas y fotos (evidencias).
        $solicitud = Solicitud::with([
            'cliente.usuario',
            'electrodomestico',
            'categoriaFalla',
            'asignaciones.tecnico.usuario',
            'citas.tecnico.usuario',
            'evidencias.usuario',
        ])->findOrFail($id);

        // También traemos la lista de técnicos por si el admin quiere asignarle uno en esta pantalla
        $tecnicos = Tecnico::with('usuario')->get();

        return view('admin.solicitudes.show', compact('solicitud', 'tecnicos'));
    }

    // =====================================================================
    // 4. ASIGNAR UN TRABAJO A UN TÉCNICO
    // =====================================================================
    public function asignarTecnico(Request $request, $id)
    {
        // Verificamos que sí haya seleccionado a un técnico de la lista
        $request->validate([
            'id_tecnico' => 'required|exists:tecnicos,id_usuario',
        ], [
            'id_tecnico.required' => 'Selecciona un técnico.',
        ]);

        $solicitud = Solicitud::findOrFail($id);
        $admin     = Auth::user()->administrador;

        // Si esta solicitud ya tenía otro técnico asignado antes, 
        // cancelamos esa asignación (la marcamos como "reasignada")
        Asignacion::where('id_solicitud', $id)
            ->where('estado', 'activa')
            ->update(['estado' => 'reasignada']);

        // Creamos el nuevo vínculo: uniendo al técnico elegido con este trabajo
        Asignacion::create([
            'id_solicitud' => $id,
            'id_tecnico'   => $request->id_tecnico,
            'id_admin'     => $admin->id_usuario, // Guardamos quién fue el admin que hizo la asignación
            'estado'       => 'activa',
        ]);

        // Actualizamos el estado general del trabajo para que ya no diga "pendiente"
        $solicitud->update(['estado_solicitud' => 'asignada']);

        // Recargamos la página con un mensaje de éxito
        return redirect()->route('admin.solicitudes.show', $id)
            ->with('success', '¡Técnico asignado correctamente!');
    }

    // =====================================================================
    // 5. PROGRAMAR UNA CITA (AGENDAR)
    // =====================================================================
    // Sirve para fijar la fecha y hora en la que el técnico irá a la casa del cliente
    public function agendarCita(Request $request, $id)
    {
        // Revisamos que pongan fecha, hora y el técnico que va a ir
        $request->validate([
            'fecha'      => 'required|date|after_or_equal:today', // No se puede viajar al pasado
            'hora'       => 'required',
            'id_tecnico' => 'required|exists:tecnicos,id_usuario',
        ], [
            'fecha.required'      => 'La fecha es obligatoria.',
            'fecha.after_or_equal'=> 'La fecha debe ser hoy o en el futuro.',
            'hora.required'       => 'La hora es obligatoria.',
            'id_tecnico.required' => 'Selecciona el técnico para la cita.',
        ]);

        // Guardamos la cita en el calendario
        Cita::create([
            'fecha'        => $request->fecha,
            'hora'         => $request->hora,
            'estado'       => 'confirmada',
            'id_solicitud' => $id,
            'id_tecnico'   => $request->id_tecnico,
        ]);

        // Actualizamos el estado del trabajo para que todos sepan que ya está agendado
        Solicitud::findOrFail($id)->update(['estado_solicitud' => 'agendada']);

        return redirect()->route('admin.solicitudes.show', $id)
            ->with('success', '¡Cita agendada correctamente!');
    }

    // =====================================================================
    // 6. CAMBIAR EL ESTADO DE UN TRABAJO MANUALMENTE
    // =====================================================================
    // Por si el admin necesita forzar un cambio de estado (ej: cancelar un trabajo)
    public function actualizarEstado(Request $request, $id)
    {
        // Nos aseguramos que elija un estado válido y no escriba cualquier cosa
        $request->validate([
            'estado_solicitud' => 'required|in:pendiente,asignada,agendada,en_proceso,completada,cancelada',
        ]);

        // Guardamos el nuevo estado
        Solicitud::findOrFail($id)->update([
            'estado_solicitud' => $request->estado_solicitud,
        ]);

        return redirect()->route('admin.solicitudes.show', $id)
            ->with('success', 'Estado actualizado correctamente.');
    }

    // =====================================================================
    // 7. VER TODOS LOS USUARIOS DEL SISTEMA
    // =====================================================================
    public function usuarios()
    {
        // Traemos la lista completa de todos los clientes y técnicos
        $clientes  = Cliente::with('usuario')->get();
        $tecnicos  = Tecnico::with('usuario')->get();

        // Mostramos la pantalla de usuarios
        return view('admin.usuarios.index', compact('clientes', 'tecnicos'));
    }

    // =====================================================================
    // 8. CAMBIAR SI UN TÉCNICO ESTÁ DISPONIBLE O NO
    // =====================================================================
    public function cambiarDisponibilidad(Request $request, $id)
    {
        // Validamos que elija una opción correcta
        $request->validate([
            'disponibilidad' => 'required|in:disponible,ocupado,inactivo',
        ]);

        // Le cambiamos el estado al técnico (por ejemplo, si se fue de vacaciones lo ponemos inactivo)
        Tecnico::where('id_usuario', $id)->update([
            'disponibilidad' => $request->disponibilidad,
        ]);

        return redirect()->route('admin.usuarios')
            ->with('success', 'Disponibilidad del técnico actualizada.');
    }
}
