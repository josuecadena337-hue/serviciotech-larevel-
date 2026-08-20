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
    // ─────────────────────────────────────────────────────────────
    // MOSTRAR FORMULARIO DE LOGIN
    // ─────────────────────────────────────────────────────────────
    public function mostrarLogin()
    {
        // Si ya hay sesión iniciada, redirige al panel
        if (Auth::check()) {
            return $this->redirigirSegunRol();
        }
        return view('auth.login');
    }

    // ─────────────────────────────────────────────────────────────
    // PROCESAR LOGIN
    // ─────────────────────────────────────────────────────────────
    public function login(Request $request)
    {
        // Validar que los campos lleguen correctos
        $request->validate([
            'correo'     => 'required|email',
            'contrasena' => 'required|min:6',
        ], [
            'correo.required'     => 'El correo es obligatorio.',
            'correo.email'        => 'Ingresa un correo válido.',
            'contrasena.required' => 'La contraseña es obligatoria.',
            'contrasena.min'      => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        // Buscar al usuario por correo
        $usuario = Usuario::where('correo', $request->correo)->first();

        // Si no existe el usuario
        if (!$usuario) {
            return back()->withErrors(['correo' => 'Usuario o contraseña incorrectos.'])->withInput();
        }

        // Si la cuenta está bloqueada
        if ($usuario->estado === 'bloqueado') {
            return back()->withErrors(['correo' => 'Tu cuenta está bloqueada. Contacta al administrador.'])->withInput();
        }

        // Verificar la contraseña
        if (!Hash::check($request->contrasena, $usuario->contrasena)) {
            // Sumar intento fallido
            $usuario->increment('intentos_fallidos');

            // Bloquear después de 3 intentos
            if ($usuario->intentos_fallidos >= 3) {
                $usuario->update(['estado' => 'bloqueado']);
                return back()->withErrors(['correo' => 'Cuenta bloqueada por demasiados intentos fallidos.'])->withInput();
            }

            $restantes = 3 - $usuario->intentos_fallidos;
            return back()->withErrors(['correo' => "Contraseña incorrecta. Te quedan {$restantes} intento(s)."])->withInput();
        }

        // Login exitoso — reiniciar intentos fallidos
        $usuario->update(['intentos_fallidos' => 0]);

        // Iniciar sesión con Laravel Auth
        Auth::login($usuario);

        // Redirigir según el rol
        return $this->redirigirSegunRol();
    }

    // ─────────────────────────────────────────────────────────────
    // MOSTRAR FORMULARIO DE REGISTRO
    // ─────────────────────────────────────────────────────────────
    public function mostrarRegistro()
    {
        if (Auth::check()) {
            return $this->redirigirSegunRol();
        }
        return view('auth.registro');
    }

    // ─────────────────────────────────────────────────────────────
    // PROCESAR REGISTRO
    // ─────────────────────────────────────────────────────────────
    public function registro(Request $request)
    {
        $request->validate([
            'nombre'     => 'required|string|max:100',
            'correo'     => 'required|email|unique:usuarios,correo',
            'telefono'   => 'nullable|string|max:20',
            'direccion'  => 'nullable|string|max:200',
            'contrasena' => 'required|min:6|confirmed',
        ], [
            'nombre.required'      => 'El nombre es obligatorio.',
            'correo.required'      => 'El correo es obligatorio.',
            'correo.unique'        => 'Este correo ya está registrado.',
            'contrasena.required'  => 'La contraseña es obligatoria.',
            'contrasena.min'       => 'La contraseña debe tener al menos 6 caracteres.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        // Obtener el rol de cliente
        $rolCliente = Rol::where('nombre', 'cliente')->first();

        // Crear el usuario
        $usuario = Usuario::create([
            'nombre'     => $request->nombre,
            'correo'     => $request->correo,
            'telefono'   => $request->telefono,
            'contrasena' => Hash::make($request->contrasena),
            'estado'     => 'activo',
            'id_rol'     => $rolCliente->id_rol,
        ]);

        // Crear el perfil de cliente
        Cliente::create([
            'id_usuario' => $usuario->id_usuario,
            'direccion'  => $request->direccion,
        ]);

        // Iniciar sesión automáticamente
        Auth::login($usuario);

        return redirect()->route('cliente.dashboard')
            ->with('success', '¡Bienvenido a ServicioTech! Tu cuenta ha sido creada.');
    }

    // ─────────────────────────────────────────────────────────────
    // CERRAR SESIÓN
    // ─────────────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }

    // ─────────────────────────────────────────────────────────────
    // HELPER: redirigir según el rol del usuario
    // ─────────────────────────────────────────────────────────────
    private function redirigirSegunRol()
    {
        $rol = Auth::user()->rol->nombre;

        return match($rol) {
            'admin'   => redirect()->route('admin.dashboard'),
            'tecnico' => redirect()->route('tecnico.dashboard'),
            'cliente' => redirect()->route('cliente.dashboard'),
            default   => redirect()->route('login'),
        };
    }
}
