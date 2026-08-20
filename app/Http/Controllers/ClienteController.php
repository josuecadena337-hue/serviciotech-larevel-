<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use App\Models\Electrodomestico;
use App\Models\Solicitud;
use App\Models\CategoriaFalla;
use App\Models\Cita;

class ClienteController extends Controller
{
    // ─────────────────────────────────────────────────────────────
    // DASHBOARD — Resumen general del cliente
    // ─────────────────────────────────────────────────────────────
    public function dashboard()
    {
        $cliente = Auth::user()->cliente;

        // Contar estadísticas para las tarjetas del dashboard
        $totalEquipos      = $cliente ? $cliente->electrodomesticos()->count() : 0;
        $solicitudesActivas = $cliente
            ? $cliente->solicitudes()
                ->whereNotIn('estado_solicitud', ['completada', 'cancelada'])
                ->count()
            : 0;
        $serviciosCompletados = $cliente
            ? $cliente->solicitudes()
                ->where('estado_solicitud', 'completada')
                ->count()
            : 0;

        // Últimas 3 solicitudes para mostrar en el dashboard
        $ultimasSolicitudes = $cliente
            ? $cliente->solicitudes()
                ->with(['electrodomestico', 'categoriaFalla'])
                ->latest()
                ->take(3)
                ->get()
            : collect();

        return view('cliente.dashboard', compact(
            'totalEquipos',
            'solicitudesActivas',
            'serviciosCompletados',
            'ultimasSolicitudes'
        ));
    }

    // ─────────────────────────────────────────────────────────────
    // MIS EQUIPOS — Lista de electrodomésticos del cliente
    // ─────────────────────────────────────────────────────────────
    public function misEquipos()
    {
        $cliente = Auth::user()->cliente;
        $equipos = $cliente
            ? $cliente->electrodomesticos()->latest()->get()
            : collect();

        return view('cliente.equipos.index', compact('equipos'));
    }

    // ─────────────────────────────────────────────────────────────
    // CREAR EQUIPO — Formulario para registrar un equipo nuevo
    // ─────────────────────────────────────────────────────────────
    public function crearEquipo()
    {
        // Tipos de electrodomésticos disponibles
        $tipos = ['Nevera', 'Lavadora', 'Aire Acondicionado', 'Estufa', 'Microondas', 'Televisor', 'Otro'];
        return view('cliente.equipos.create', compact('tipos'));
    }

    // ─────────────────────────────────────────────────────────────
    // GUARDAR EQUIPO — Almacena el nuevo equipo en la BD
    // ─────────────────────────────────────────────────────────────
    public function guardarEquipo(Request $request)
    {
        $request->validate([
            'tipo'   => 'required|string|max:100',
            'marca'  => 'required|string|max:100',
            'modelo' => 'nullable|string|max:100',
            'serie'  => 'nullable|string|max:100|unique:electrodomesticos,serie',
        ], [
            'tipo.required'  => 'Selecciona el tipo de electrodoméstico.',
            'marca.required' => 'La marca es obligatoria.',
            'serie.unique'   => 'Este número de serie ya está registrado.',
        ]);

        $cliente = Auth::user()->cliente;

        Electrodomestico::create([
            'tipo'       => $request->tipo,
            'marca'      => $request->marca,
            'modelo'     => $request->modelo,
            'serie'      => $request->serie,
            'id_cliente' => $cliente->id_usuario,
        ]);

        return redirect()->route('cliente.equipos')
            ->with('success', '¡Equipo registrado correctamente!');
    }

    // ─────────────────────────────────────────────────────────────
    // SOLICITAR SERVICIO — Formulario para crear solicitud
    // ─────────────────────────────────────────────────────────────
    public function solicitarServicio()
    {
        $cliente    = Auth::user()->cliente;
        $equipos    = $cliente ? $cliente->electrodomesticos()->get() : collect();
        $categorias = CategoriaFalla::all();

        return view('cliente.solicitudes.create', compact('equipos', 'categorias'));
    }

    // ─────────────────────────────────────────────────────────────
    // GUARDAR SOLICITUD — Almacena la solicitud en la BD
    // ─────────────────────────────────────────────────────────────
    public function guardarSolicitud(Request $request)
    {
        $request->validate([
            'id_equipo'            => 'required|exists:electrodomesticos,id_equipo',
            'id_categoria'         => 'required|exists:categoria_falla,id_categoria',
            'tipo_solicitud'       => 'required|in:preventivo,correctivo',
            'descripcion_problema' => 'required|string|min:10|max:500',
        ], [
            'id_equipo.required'            => 'Selecciona un equipo.',
            'id_categoria.required'         => 'Selecciona una categoría.',
            'tipo_solicitud.required'       => 'Selecciona el tipo de servicio.',
            'descripcion_problema.required' => 'Describe el problema.',
            'descripcion_problema.min'      => 'La descripción debe tener al menos 10 caracteres.',
        ]);

        $cliente = Auth::user()->cliente;

        Solicitud::create([
            'tipo_solicitud'       => $request->tipo_solicitud,
            'descripcion_problema' => $request->descripcion_problema,
            'estado_solicitud'     => 'pendiente',
            'id_cliente'           => $cliente->id_usuario,
            'id_equipo'            => $request->id_equipo,
            'id_categoria'         => $request->id_categoria,
        ]);

        return redirect()->route('cliente.solicitudes')
            ->with('success', '¡Solicitud enviada! Te notificaremos cuando se asigne un técnico.');
    }

    // ─────────────────────────────────────────────────────────────
    // MIS SOLICITUDES — Lista de solicitudes del cliente
    // ─────────────────────────────────────────────────────────────
    public function misSolicitudes()
    {
        $cliente = Auth::user()->cliente;
        $solicitudes = $cliente
            ? $cliente->solicitudes()
                ->with(['electrodomestico', 'categoriaFalla', 'asignaciones.tecnico.usuario'])
                ->latest()
                ->get()
            : collect();

        return view('cliente.solicitudes.index', compact('solicitudes'));
    }

    // ─────────────────────────────────────────────────────────────
    // VER SOLICITUD — Detalle de una solicitud específica
    // ─────────────────────────────────────────────────────────────
    public function verSolicitud($id)
    {
        $cliente = Auth::user()->cliente;

        // Verificar que la solicitud pertenece al cliente
        $solicitud = Solicitud::with([
            'electrodomestico',
            'categoriaFalla',
            'asignaciones.tecnico.usuario',
            'citas',
            'evidencias.usuario',
        ])->where('id_solicitud', $id)
          ->where('id_cliente', $cliente->id_usuario)
          ->firstOrFail();

        return view('cliente.solicitudes.show', compact('solicitud'));
    }

    // ─────────────────────────────────────────────────────────────
    // MIS CITAS — Lista de citas del cliente
    // ─────────────────────────────────────────────────────────────
    public function misCitas()
    {
        $cliente = Auth::user()->cliente;
        $citas = $cliente
            ? Cita::whereHas('solicitud', fn($q) => $q->where('id_cliente', $cliente->id_usuario))
                ->with(['solicitud.electrodomestico', 'tecnico.usuario'])
                ->orderBy('fecha', 'desc')
                ->get()
            : collect();

        return view('cliente.citas.index', compact('citas'));
    }
}
