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
    // =====================================================================
    // 1. PANTALLA PRINCIPAL (DASHBOARD)
    // =====================================================================
    // Aquí preparamos toda la información que el cliente ve al entrar a su cuenta:
    // cuántos equipos tiene, cuántos servicios ha pedido y sus solicitudes recientes.
    public function dashboard()
    {
        // Obtenemos los datos del cliente que tiene la sesión abierta
        $cliente = Auth::user()->cliente;

        // Contamos cuántos electrodomésticos tiene registrados
        $totalEquipos      = $cliente ? $cliente->electrodomesticos()->count() : 0;
        
        // Contamos cuántas solicitudes están en proceso (que no estén terminadas ni canceladas)
        $solicitudesActivas = $cliente
            ? $cliente->solicitudes()
                ->whereNotIn('estado_solicitud', ['completada', 'cancelada'])
                ->count()
            : 0;
            
        // Contamos cuántas reparaciones ya se le terminaron
        $serviciosCompletados = $cliente
            ? $cliente->solicitudes()
                ->where('estado_solicitud', 'completada')
                ->count()
            : 0;

        // Buscamos sus últimas 3 solicitudes para mostrarlas como resumen rápido
        $ultimasSolicitudes = $cliente
            ? $cliente->solicitudes()
                ->with(['electrodomestico', 'categoriaFalla'])
                ->latest()
                ->take(3)
                ->get()
            : collect();

        // Mandamos toda esta información a la vista (el archivo HTML del dashboard)
        return view('cliente.dashboard', compact(
            'totalEquipos',
            'solicitudesActivas',
            'serviciosCompletados',
            'ultimasSolicitudes'
        ));
    }

    // =====================================================================
    // 2. VER TODOS SUS ELECTRODOMÉSTICOS
    // =====================================================================
    public function misEquipos()
    {
        // Buscamos al cliente actual
        $cliente = Auth::user()->cliente;
        
        // Traemos todos los equipos que ha registrado, ordenados del más nuevo al más viejo
        $equipos = $cliente
            ? $cliente->electrodomesticos()->latest()->get()
            : collect();

        // Le mostramos la pantalla con su lista de equipos
        return view('cliente.equipos.index', compact('equipos'));
    }

    // =====================================================================
    // 3. MOSTRAR EL FORMULARIO PARA REGISTRAR UN EQUIPO NUEVO
    // =====================================================================
    public function crearEquipo()
    {
        // Le damos una lista de opciones predefinidas para que elija qué aparato registrará
        $tipos = ['Nevera', 'Lavadora', 'Aire Acondicionado', 'Estufa', 'Microondas', 'Televisor', 'Otro'];
        
        // Mostramos el formulario de creación
        return view('cliente.equipos.create', compact('tipos'));
    }

    // =====================================================================
    // 4. GUARDAR EL EQUIPO NUEVO EN LA BASE DE DATOS
    // =====================================================================
    public function guardarEquipo(Request $request)
    {
        // Revisamos que haya llenado lo obligatorio (tipo y marca)
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

        // Guardamos el aparato en la base de datos asociado a este cliente
        Electrodomestico::create([
            'tipo'       => $request->tipo,
            'marca'      => $request->marca,
            'modelo'     => $request->modelo,
            'serie'      => $request->serie,
            'id_cliente' => $cliente->id_usuario,
        ]);

        // Lo regresamos a su lista de equipos con un mensaje de éxito
        return redirect()->route('cliente.equipos')
            ->with('success', '¡Equipo registrado correctamente!');
    }

    // =====================================================================
    // 5. MOSTRAR EL FORMULARIO PARA PEDIR UNA REPARACIÓN
    // =====================================================================
    public function solicitarServicio()
    {
        $cliente    = Auth::user()->cliente;
        
        // Necesitamos saber qué equipos tiene para que elija cuál está fallando
        $equipos    = $cliente ? $cliente->electrodomesticos()->get() : collect();
        
        // Y le pasamos las categorías de fallas (ej: "Mantenimiento preventivo", "No enfría")
        $categorias = CategoriaFalla::all();

        // Mostramos el formulario para pedir la reparación
        return view('cliente.solicitudes.create', compact('equipos', 'categorias'));
    }

    // =====================================================================
    // 6. GUARDAR LA SOLICITUD DE REPARACIÓN
    // =====================================================================
    public function guardarSolicitud(Request $request)
    {
        // Verificamos que elija su equipo, el tipo de servicio y nos explique qué pasa
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

        // Creamos la solicitud de servicio y la guardamos
        Solicitud::create([
            'tipo_solicitud'       => $request->tipo_solicitud,
            'descripcion_problema' => $request->descripcion_problema,
            'estado_solicitud'     => 'pendiente', // Empieza pendiente hasta que el admin la asigne
            'id_cliente'           => $cliente->id_usuario,
            'id_equipo'            => $request->id_equipo,
            'id_categoria'         => $request->id_categoria,
        ]);

        // Lo mandamos a ver todas sus solicitudes con un mensaje de confirmación
        return redirect()->route('cliente.solicitudes')
            ->with('success', '¡Solicitud enviada! Te notificaremos cuando se asigne un técnico.');
    }

    // =====================================================================
    // 7. VER TODAS SUS SOLICITUDES (HISTORIAL)
    // =====================================================================
    public function misSolicitudes()
    {
        $cliente = Auth::user()->cliente;
        
        // Traemos todas las peticiones de reparación que ha hecho, 
        // incluyendo los datos del equipo y del técnico (si ya le asignaron uno)
        $solicitudes = $cliente
            ? $cliente->solicitudes()
                ->with(['electrodomestico', 'categoriaFalla', 'asignaciones.tecnico.usuario'])
                ->latest()
                ->get()
            : collect();

        // Mostramos la lista en pantalla
        return view('cliente.solicitudes.index', compact('solicitudes'));
    }

    // =====================================================================
    // 8. VER LOS DETALLES DE UNA SOLICITUD EN ESPECÍFICO
    // =====================================================================
    public function verSolicitud($id)
    {
        $cliente = Auth::user()->cliente;

        // Buscamos la solicitud, pero POR SEGURIDAD nos aseguramos de que sea
        // exclusivamente de este cliente (para que nadie pueda ver las reparaciones de otros)
        $solicitud = Solicitud::with([
            'electrodomestico',
            'categoriaFalla',
            'asignaciones.tecnico.usuario',
            'citas',
            'evidencias.usuario', // Para que el cliente pueda ver las fotos que sube el técnico
        ])->where('id_solicitud', $id)
          ->where('id_cliente', $cliente->id_usuario) // Este filtro de seguridad es clave
          ->firstOrFail();

        // Mostramos la pantalla con todos los detalles
        return view('cliente.solicitudes.show', compact('solicitud'));
    }

    // =====================================================================
    // 9. VER LAS CITAS PROGRAMADAS CON EL TÉCNICO
    // =====================================================================
    public function misCitas()
    {
        $cliente = Auth::user()->cliente;
        
        // Buscamos todas las fechas que el técnico agendó para ir a visitar a este cliente
        // (Buscamos las citas que pertenezcan a las solicitudes de este cliente)
        $citas = $cliente
            ? Cita::whereHas('solicitud', fn($q) => $q->where('id_cliente', $cliente->id_usuario))
                ->with(['solicitud.electrodomestico', 'tecnico.usuario'])
                ->orderBy('fecha', 'desc')
                ->get()
            : collect();

        // Le mostramos su agenda de visitas
        return view('cliente.citas.index', compact('citas'));
    }
}
