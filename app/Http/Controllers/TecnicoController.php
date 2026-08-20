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
    // ─────────────────────────────────────────────────────────────
    // DASHBOARD — Resumen del técnico
    // ─────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $tecnico = Auth::user()->tecnico;

        $totalAsignadas   = Asignacion::where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')->count();
        $enProceso        = Solicitud::whereHas('asignaciones', fn($q) =>
            $q->where('id_tecnico', $tecnico->id_usuario)->where('estado', 'activa'))
            ->where('estado_solicitud', 'en_proceso')->count();
        $completadas      = Solicitud::whereHas('asignaciones', fn($q) =>
            $q->where('id_tecnico', $tecnico->id_usuario))
            ->where('estado_solicitud', 'completada')->count();

        // Citas de hoy
        $citasHoy = Cita::where('id_tecnico', $tecnico->id_usuario)
            ->whereDate('fecha', today())
            ->with('solicitud.cliente.usuario', 'solicitud.electrodomestico')
            ->get();

        // Mis solicitudes activas
        $misAsignaciones = Asignacion::where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')
            ->with('solicitud.cliente.usuario', 'solicitud.electrodomestico', 'solicitud.categoriaFalla')
            ->latest()
            ->take(5)
            ->get();

        return view('tecnico.dashboard', compact(
            'totalAsignadas', 'enProceso', 'completadas',
            'citasHoy', 'misAsignaciones'
        ));
    }

    // ─────────────────────────────────────────────────────────────
    // MIS ASIGNACIONES — Lista completa
    // ─────────────────────────────────────────────────────────────
    public function misAsignaciones()
    {
        $tecnico = Auth::user()->tecnico;

        $asignaciones = Asignacion::where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')
            ->with('solicitud.cliente.usuario', 'solicitud.electrodomestico', 'solicitud.categoriaFalla')
            ->latest()
            ->get();

        return view('tecnico.asignaciones.index', compact('asignaciones'));
    }

    // ─────────────────────────────────────────────────────────────
    // VER SOLICITUD — Detalle con opciones para el técnico
    // ─────────────────────────────────────────────────────────────
    public function verSolicitud($id)
    {
        $tecnico = Auth::user()->tecnico;

        // Verificar que la solicitud está asignada a este técnico
        $asignacion = Asignacion::where('id_solicitud', $id)
            ->where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')
            ->firstOrFail();

        $solicitud = Solicitud::with([
            'cliente.usuario',
            'electrodomestico',
            'categoriaFalla',
            'citas',
            'evidencias.usuario',
        ])->findOrFail($id);

        return view('tecnico.asignaciones.show', compact('solicitud', 'asignacion'));
    }

    // ─────────────────────────────────────────────────────────────
    // ACTUALIZAR ESTADO — El técnico cambia el estado del servicio
    // ─────────────────────────────────────────────────────────────
    public function actualizarEstado(Request $request, $id)
    {
        $request->validate([
            'estado_solicitud' => 'required|in:en_proceso,completada',
        ]);

        $tecnico = Auth::user()->tecnico;

        // Verificar que la solicitud le pertenece
        Asignacion::where('id_solicitud', $id)
            ->where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')
            ->firstOrFail();

        Solicitud::findOrFail($id)->update([
            'estado_solicitud' => $request->estado_solicitud,
        ]);

        $mensaje = $request->estado_solicitud === 'completada'
            ? '¡Servicio marcado como completado!'
            : 'Servicio marcado como en proceso.';

        return redirect()->route('tecnico.solicitudes.show', $id)
            ->with('success', $mensaje);
    }

    // ─────────────────────────────────────────────────────────────
    // SUBIR EVIDENCIA — Fotos o descripción del trabajo
    // ─────────────────────────────────────────────────────────────
    public function subirEvidencia(Request $request, $id)
    {
        $request->validate([
            'tipo'        => 'required|in:foto,video,documento',
            'descripcion' => 'required|string|min:5|max:300',
            'archivo'     => 'nullable|file|max:5120', // max 5MB
        ], [
            'tipo.required'        => 'Selecciona el tipo de evidencia.',
            'descripcion.required' => 'Escribe una descripción.',
            'descripcion.min'      => 'La descripción debe tener al menos 5 caracteres.',
            'archivo.max'          => 'El archivo no debe superar 5MB.',
        ]);

        $tecnico = Auth::user()->tecnico;

        // Verificar que la solicitud le pertenece
        Asignacion::where('id_solicitud', $id)
            ->where('id_tecnico', $tecnico->id_usuario)
            ->where('estado', 'activa')
            ->firstOrFail();

        // Manejar archivo si se subió
        $urlArchivo = 'sin-archivo';
        if ($request->hasFile('archivo')) {
            $archivo    = $request->file('archivo');
            $nombreFile = time() . '_' . $archivo->getClientOriginalName();
            $archivo->storeAs('evidencias', $nombreFile, 'public');
            $urlArchivo = 'storage/evidencias/' . $nombreFile;
        }

        Evidencia::create([
            'tipo'         => $request->tipo,
            'url_archivo'  => $urlArchivo,
            'descripcion'  => $request->descripcion,
            'id_solicitud' => $id,
            'subido_por'   => Auth::user()->id_usuario,
        ]);

        return redirect()->route('tecnico.solicitudes.show', $id)
            ->with('success', '¡Evidencia registrada correctamente!');
    }

    // ─────────────────────────────────────────────────────────────
    // MIS CITAS — Agenda del técnico
    // ─────────────────────────────────────────────────────────────
    public function misCitas()
    {
        $tecnico = Auth::user()->tecnico;

        $citas = Cita::where('id_tecnico', $tecnico->id_usuario)
            ->with('solicitud.cliente.usuario', 'solicitud.electrodomestico')
            ->orderBy('fecha', 'asc')
            ->get();

        return view('tecnico.citas.index', compact('citas'));
    }
}
