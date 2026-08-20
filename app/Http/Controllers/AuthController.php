<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Rol;

class AuthController extends Controller
{
    // =====================================================================
    // 1. MOSTRAR LA PANTALLA DE INICIO DE SESIÓN (LOGIN)
    // =====================================================================
    public function mostrarLogin()
    {
        // Si la persona ya tiene su sesión abierta, no le mostramos el login,
        // lo mandamos directo a su panel (dependiendo de si es admin, técnico o cliente)
        if (Auth::check()) {
            return $this->redirigirSegunRol();
        }
        
        // Si no tiene sesión, le mostramos la vista (el HTML) del login
        return view('auth.login');
    }

    // =====================================================================
    // 2. PROCESAR LOS DATOS CUANDO EL USUARIO INTENTA INGRESAR
    // =====================================================================
    public function login(Request $request)
    {
        // Primero, verificamos que el usuario haya llenado los campos correctamente
        // y preparamos mensajes de error amigables por si se equivoca
        $request->validate([
            'correo'     => 'required|email',
            'contrasena' => 'required|min:6',
        ], [
            'correo.required'     => 'El correo es obligatorio.',
            'correo.email'        => 'Ingresa un correo válido.',
            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.min'      => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        // Buscamos en la base de datos si existe alguien registrado con ese correo
        $usuario = Usuario::where('correo', $request->correo)->first();

        // Si no encontramos a nadie, lo devolvemos con un error
        if (!$usuario) {
            return back()->withErrors(['correo' => 'Usuario o contraseña incorrectos.'])->withInput();
        }

        // Revisamos si el administrador bloqueó a esta persona
        if ($usuario->estado === 'bloqueado') {
            return back()->withErrors(['correo' => 'Tu cuenta está bloqueada. Contacta al administrador.'])->withInput();
        }

        // Aquí comprobamos si la contraseña que escribió coincide con la que tenemos guardada
        if (!Hash::check($request->contrasena, $usuario->contrasena)) {
            
            // Si se equivocó, le sumamos 1 a su contador de intentos fallidos
            $usuario->increment('intentos_fallidos');

            // Si se equivoca 3 veces, bloqueamos su cuenta por seguridad
            if ($usuario->intentos_fallidos >= 3) {
                $usuario->update(['estado' => 'bloqueado']);
                return back()->withErrors(['correo' => 'Cuenta bloqueada por demasiados intentos fallidos.'])->withInput();
            }

            // Si aún le quedan intentos, le avisamos cuántos son
            $restantes = 3 - $usuario->intentos_fallidos;
            return back()->withErrors(['correo' => "Contraseña incorrecta. Te quedan {$restantes} intento(s)."])->withInput();
        }

        // Si llegó hasta aquí, ¡el correo y la contraseña son correctos!
        // Entonces ponemos sus intentos fallidos de nuevo en cero
        $usuario->update(['intentos_fallidos' => 0]);

        // Iniciamos su sesión oficialmente en el sistema
        Auth::login($usuario);

        // Y lo mandamos a su panel correspondiente
        return $this->redirigirSegunRol();
    }

    // =====================================================================
    // 3. MOSTRAR LA PANTALLA DE REGISTRO
    // =====================================================================
    public function mostrarRegistro()
    {
        // Igual que en el login, si ya inició sesión no necesita registrarse
        if (Auth::check()) {
            return $this->redirigirSegunRol();
        }
        
        // Le mostramos el HTML del formulario de registro
        return view('auth.registro');
    }

    // =====================================================================
    // 4. GUARDAR A UN USUARIO NUEVO EN LA BASE DE DATOS
    // =====================================================================
    public function registro(Request $request)
    {
        // Revisamos que los datos del formulario estén completos y correctos
        $request->validate([
            'nombre'     => 'required|string|max:100',
            'correo'     => 'required|email|unique:usuarios,correo',
            'telefono'   => 'nullable|string|max:20',
            'direccion'  => 'nullable|string|max:200',
            'contrasena' => 'required|min:6|confirmed', // 'confirmed' obliga a que las contraseñas coincidan
        ], [
            'nombre.required'      => 'El nombre es obligatorio.',
            'correo.required'      => 'El correo es obligatorio.',
            'correo.unique'        => 'Este correo ya está registrado.',
            'contrasena.required'  => 'La contraseña es obligatoria.',
            'contrasena.min'       => 'La contraseña debe tener al menos 6 caracteres.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Por defecto, cualquier persona nueva que se registre por aquí será un "cliente"
        $rolCliente = Rol::where('nombre', 'cliente')->first();

        // Guardamos los datos principales del usuario en la tabla 'usuarios'
        $usuario = Usuario::create([
            'nombre'     => $request->nombre,
            'correo'     => $request->correo,
            'telefono'   => $request->telefono,
            'contrasena' => Hash::make($request->contrasena), // Encriptamos la contraseña por seguridad
            'estado'     => 'activo',
            'id_rol'     => $rolCliente->id_rol,
        ]);

        // Como es cliente, le creamos también su perfil específico en la tabla 'clientes'
        // donde guardamos cosas extra como su dirección
        Cliente::create([
            'id_usuario' => $usuario->id_usuario,
            'direccion'  => $request->direccion,
        ]);

        // Una vez registrado, le iniciamos la sesión automáticamente para que no tenga que hacer login
        Auth::login($usuario);

        // Y lo mandamos a su nuevo panel de cliente con un mensaje de bienvenida
        return redirect()->route('cliente.dashboard')
            ->with('success', '¡Bienvenido a ServicioTech! Tu cuenta ha sido creada.');
    }

    // =====================================================================
    // 5. CERRAR SESIÓN (LOGOUT)
    // =====================================================================
    public function logout(Request $request)
    {
        // Guardamos el rol del usuario ANTES de cerrar su sesión para saber a dónde redirigirlo
        $rol = Auth::check() ? Auth::user()->rol->nombre : null;

        // Cerramos la sesión
        Auth::logout();
        
        // Limpiamos los datos de seguridad temporales del navegador
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Si el usuario era un cliente, lo redirigimos a la portada pública (welcome)
        if ($rol === 'cliente') {
            return redirect()->route('inicio');
        }

        // Si era Admin o Técnico, mantenemos el comportamiento anterior (regresar al login)
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    // =====================================================================
    // 6. HERRAMIENTA EXTRA: SABER A DÓNDE MANDAR A CADA QUIEN
    // =====================================================================
    private function redirigirSegunRol()
    {
        // Miramos qué rol tiene la persona que acaba de entrar (admin, tecnico o cliente)
        $rol = Auth::user()->rol->nombre;

        // Dependiendo de su rol, lo enviamos a su pantalla correspondiente
        return match($rol) {
            'admin'   => redirect()->route('admin.dashboard'),
            'tecnico' => redirect()->route('tecnico.dashboard'),
            'cliente' => redirect()->route('cliente.dashboard'),
            default   => redirect()->route('login'),
        };
    }
}
