<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión — ServicioTech</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a237e 0%, #3949ab 50%, #42a5f5 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .card {
            background: white;
            border-radius: 16px;
            width: 100%;
            max-width: 420px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0,0,0,0.3);
        }

        .card-header {
            background: linear-gradient(135deg, #1a237e, #3949ab);
            padding: 35px 40px;
            text-align: center;
            color: white;
        }

        .card-header .icon {
            width: 64px; height: 64px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 16px;
            font-size: 28px;
        }

        .card-header h1 { font-size: 1.6rem; font-weight: 700; }
        .card-header p  { font-size: 0.9rem; opacity: 0.85; margin-top: 4px; }

        .card-body { padding: 35px 40px; }

        /* Alertas de error */
        .alert-error {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #dc2626;
            font-size: 0.875rem;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-bottom: 20px;
            color: #16a34a;
            font-size: 0.875rem;
        }

        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            font-size: 0.95rem;
            font-family: 'Inter', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
            outline: none;
        }

        .form-group input:focus {
            border-color: #3949ab;
            box-shadow: 0 0 0 3px rgba(57,73,171,0.1);
        }

        .form-group input.error { border-color: #dc2626; }

        .error-msg {
            color: #dc2626;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #1a237e, #3949ab);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: transform 0.1s, box-shadow 0.2s;
            margin-top: 8px;
        }

        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(57,73,171,0.4);
        }

        .btn-login:active { transform: translateY(0); }

        .divider {
            text-align: center;
            margin: 20px 0;
            color: #9ca3af;
            font-size: 0.875rem;
            position: relative;
        }
        .divider::before, .divider::after {
            content: '';
            position: absolute;
            top: 50%; width: 40%;
            height: 1px;
            background: #e5e7eb;
        }
        .divider::before { left: 0; }
        .divider::after  { right: 0; }

        .link-register {
            text-align: center;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .link-register a {
            color: #3949ab;
            font-weight: 600;
            text-decoration: none;
        }

        .link-register a:hover { text-decoration: underline; }

        /* Credenciales de prueba */
        .test-creds {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 16px;
            margin-top: 20px;
            font-size: 0.8rem;
            color: #64748b;
        }
        .test-creds strong { color: #1a237e; }
        .test-creds table { width: 100%; margin-top: 6px; border-collapse: collapse; }
        .test-creds td { padding: 2px 4px; }
    </style>
</head>
<body>

<div class="card">

    {{-- ENCABEZADO --}}
    <div class="card-header">
        <div class="icon">🔒</div>
        <h1>ServicioTech</h1>
        <p>Iniciar Sesión</p>
    </div>

    {{-- CUERPO DEL FORMULARIO --}}
    <div class="card-body">

        {{-- Mensaje de éxito (ej: después de cerrar sesión) --}}
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{-- Errores generales --}}
        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Campo correo --}}
            <div class="form-group">
                <label>✉️ Correo Electrónico</label>
                <input
                    type="email"
                    name="correo"
                    id="correo"
                    placeholder="usuario@ejemplo.com"
                    value="{{ old('correo') }}"
                    class="{{ $errors->has('correo') ? 'error' : '' }}"
                    required
                    autofocus
                >
                @error('correo')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo contraseña --}}
            <div class="form-group">
                <label>🔑 Contraseña</label>
                <input
                    type="password"
                    name="contrasena"
                    id="contrasena"
                    placeholder="••••••••"
                    class="{{ $errors->has('contrasena') ? 'error' : '' }}"
                    required
                >
                @error('contrasena')
                    <p class="error-msg">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-login">Iniciar Sesión</button>
        </form>

        <div class="divider">o</div>

        <div class="link-register">
            ¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate aquí</a>
        </div>

        {{-- Credenciales de prueba --}}
        <div class="test-creds">
            <strong>🧪 Credenciales de prueba:</strong>
            <table>
                <tr><td>Admin:</td><td>admin@serviciotech.com / admin123</td></tr>
                <tr><td>Técnico:</td><td>carlos@serviciotech.com / tecnico123</td></tr>
                <tr><td>Cliente:</td><td>juan@gmail.com / cliente123</td></tr>
            </table>
        </div>

    </div>
</div>

</body>
</html>
