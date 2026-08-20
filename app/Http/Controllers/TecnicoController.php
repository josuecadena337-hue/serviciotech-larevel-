<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Asignacion;
use App\Models\Solicitud;
use App\Models\Evidencia;
use App\Models\Cita;

class TecnicoController extends Controller
{
    // =====================================================================
    // 1. PANTALLA PRINCIPAL DEL TÉCNICO (DASHBOARD)
    // =====================================================================
    // Aquí el técnico ve un resumen rápido de su día: cuántos trabajos tiene
    // asignados, cuántos ya terminó y a qué casas tiene que ir hoy.
    public function dashboard()
    {
        // Obtenemos los datos del técnico que acaba de iniciar sesión
        $tecnico = Auth::user()->tecnico;

        // Contamos cuántos trabajos tiene asignados en total actualmente
        $totalAsignadas   = Asignacion::where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')->count();
            
        // Contamos cuántos de esos trabajos ya empezó (están "en proceso")
        $enProceso        = Solicitud::whereHas('asignaciones', fn($q) =>
            $q->where('id_tecnico', $tecnico->id_usuario)->where('estado', 'activa'))
            ->where('estado_solicitud', 'en_proceso')->count();
            
        // Contamos cuántos trabajos ha logrado terminar (completadas)
        $completadas      = Solicitud::whereHas('asignaciones', fn($q) =>
            $q->where('id_tecnico', $tecnico->id_usuario))
            ->where('estado_solicitud', 'completada')->count();

        // Buscamos las citas (visitas) que el técnico tiene programadas específicamente para el día de HOY
        $citasHoy = Cita::where('id_tecnico', $tecnico->id_usuario)
            ->whereDate('fecha', today())
            ->with('solicitud.cliente.usuario', 'solicitud.electrodomestico')
            ->get();

        // Traemos sus últimos 5 trabajos asignados para mostrarlos en una lista rápida
        $misAsignaciones = Asignacion::where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')
            ->with('solicitud.cliente.usuario', 'solicitud.electrodomestico', 'solicitud.categoriaFalla')
            ->latest()
            ->take(5)
            ->get();

        // Mandamos toda esta información a su pantalla de inicio
        return view('tecnico.dashboard', compact(
            'totalAsignadas', 'enProceso', 'completadas',
            'citasHoy', 'misAsignaciones'
        ));
    }

    // =====================================================================
    // 2. VER TODAS LAS REPARACIONES QUE LE HAN ASIGNADO
    // =====================================================================
    // Muestra la lista completa de todos los trabajos que el jefe le dio a este técnico
    public function misAsignaciones()
    {
        $tecnico = Auth::user()->tecnico;

        // Buscamos las asignaciones activas de este técnico con los datos del cliente y su aparato
        $asignaciones = Asignacion::where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')
            ->with('solicitud.cliente.usuario', 'solicitud.electrodomestico', 'solicitud.categoriaFalla')
            ->latest()
            ->get();

        return view('tecnico.asignaciones.index', compact('asignaciones'));
    }

    // =====================================================================
    // 3. VER LOS DETALLES DE UN TRABAJO EN ESPECÍFICO
    // =====================================================================
    public function verSolicitud($id)
    {
        $tecnico = Auth::user()->tecnico;

        // Por seguridad, verificamos que el trabajo que está intentando ver
        // realmente le pertenezca a él y no a otro técnico
        $asignacion = Asignacion::where('id_solicitud', $id)
            ->where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')
            ->firstOrFail();

        // Traemos todos los detalles: datos del cliente, fallas, citas y fotos subidas
        $solicitud = Solicitud::with([
            'cliente.usuario',
            'electrodomestico',
            'categoriaFalla',
            'citas',
            'evidencias.usuario',
        ])->findOrFail($id);

        return view('tecnico.asignaciones.show', compact('solicitud', 'asignacion'));
    }

    // =====================================================================
    // 4. ACTUALIZAR CÓMO VA EL TRABAJO
    // =====================================================================
    // El técnico usa esto para avisar si ya empezó el trabajo o si ya lo terminó
    public function actualizarEstado(Request $request, $id)
    {
        // Solo le permitimos cambiar el estado a "en proceso" o "completada"
        $request->validate([
            'estado_solicitud' => 'required|in:en_proceso,completada',
        ]);

        $tecnico = Auth::user()->tecnico;

        // Validamos nuevamente que este trabajo sea suyo antes de dejarle cambiar el estado
        Asignacion::where('id_solicitud', $id)
            ->where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')
            ->firstOrFail();

        // Guardamos el nuevo estado en la base de datos
        Solicitud::findOrFail($id)->update([
            'estado_solicitud' => $request->estado_solicitud,
        ]);

        // Preparamos un mensaje bonito para mostrarle dependiendo de qué botón presionó
        $mensaje = $request->estado_solicitud === 'completada'
            ? '¡Servicio marcado como completado!'
            : 'Servicio marcado como en proceso.';

        return redirect()->route('tecnico.solicitudes.show', $id)
            ->with('success', $mensaje);
    }

    // =====================================================================
    // 5. SUBIR FOTOS O NOTAS (EVIDENCIAS)
    // =====================================================================
    // Aquí el técnico puede subir fotos del aparato reparado o dejar notas sobre el trabajo
    public function subirEvidencia(Request $request, $id)
    {
        // Revisamos que haya llenado la descripción y que el archivo no sea demasiado pesado
        $request->validate([
            'tipo'        => 'required|in:foto,video,documento',
            'descripcion' => 'required|string|min:5|max:300',
            'archivo'     => 'nullable|file|max:5120', // máximo 5MB
        ], [
            'tipo.required'        => 'Selecciona el tipo de evidencia.',
            'descripcion.required' => 'Escribe una descripción.',
            'descripcion.min'      => 'La descripción debe tener al menos 5 caracteres.',
            'archivo.max'          => 'El archivo no debe superar 5MB.',
        ]);

        $tecnico = Auth::user()->tecnico;

        // Validamos por seguridad que el trabajo es suyo
        Asignacion::where('id_solicitud', $id)
            ->where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')
            ->firstOrFail();

        // Si el técnico subió un archivo (una foto por ejemplo), lo guardamos en el servidor
        $urlArchivo = 'sin-archivo';
        if ($request->hasFile('archivo')) {
            $archivo    = $request->file('archivo');
            // Le ponemos un nombre único usando la fecha y hora para que no se borren fotos iguales
            $nombreFile = time() . '_' . $archivo->getClientOriginalName();
            // Lo guardamos en la carpeta "evidencias"
            $archivo->storeAs('evidencias', $nombreFile, 'public');
            $urlArchivo = 'storage/evidencias/' . $nombreFile;
        }

        // Guardamos toda la información de la nota/foto en la base de datos
        Evidencia::create([
            'tipo'         => $request->tipo,
            'url_archivo'  => $urlArchivo,
            'descripcion'  => $request->descripcion,
            'id_solicitud' => $id,
            'subido_por'   => Auth::user()->id_usuario, // Registramos quién subió esto
        ]);

        return redirect()->route('tecnico.solicitudes.show', $id)
            ->with('success', '¡Evidencia registrada correctamente!');
    }

    // =====================================================================
    // 6. VER SU AGENDA DE CITAS
    // =====================================================================
    // Aquí el técnico puede ver todas las visitas que tiene programadas en su calendario
    public function misCitas()
    {
        $tecnico = Auth::user()->tecnico;

        // Buscamos todas las citas asignadas a él y las ordenamos por fecha
        $citas = Cita::where('id_tecnico', $tecnico->id_usuario)
            ->with('solicitud.cliente.usuario', 'solicitud.electrodomestico')
            ->orderBy('fecha', 'asc')
            ->get();

        return view('tecnico.citas.index', compact('citas'));
    }
}
