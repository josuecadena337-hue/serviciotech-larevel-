<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro — ServicioTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a237e 0%, #3949ab 50%, #42a5f5 100%);
            display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .card { background: white; border-radius: 16px; width: 100%; max-width: 460px; overflow: hidden; box-shadow: 0 25px 60px rgba(0,0,0,0.3); }
        .card-header { background: linear-gradient(135deg, #1a237e, #3949ab); padding: 28px 40px; text-align: center; color: white; }
        .card-header .icon { width: 56px; height: 56px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 24px; }
        .card-header h1 { font-size: 1.5rem; font-weight: 700; }
        .card-header p  { font-size: 0.875rem; opacity: 0.85; margin-top: 4px; }
        .card-body { padding: 30px 40px; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; color: #dc2626; font-size: 0.875rem; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.875rem; font-weight: 500; color: #374151; margin-bottom: 6px; }
        .form-group input { width: 100%; padding: 11px 14px; border: 1.5px solid #e5e7eb; border-radius: 8px; font-size: 0.9rem; font-family: 'Inter', sans-serif; transition: border-color 0.2s, box-shadow 0.2s; outline: none; }
        .form-group input:focus { border-color: #3949ab; box-shadow: 0 0 0 3px rgba(57,73,171,0.1); }
        .form-group input.error { border-color: #dc2626; }
        .error-msg { color: #dc2626; font-size: 0.8rem; margin-top: 4px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
        .btn-register { width: 100%; padding: 13px; background: linear-gradient(135deg, #1a237e, #3949ab); color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: transform 0.1s, box-shadow 0.2s; margin-top: 6px; }
        .btn-register:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(57,73,171,0.4); }
        .link-login { text-align: center; font-size: 0.9rem; color: #6b7280; margin-top: 18px; }
        .link-login a { color: #3949ab; font-weight: 600; text-decoration: none; }
        .link-login a:hover { text-decoration: underline; }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <div class="icon">👤</div>
        <h1>Crear Cuenta</h1>
        <p>Regístrate en ServicioTech</p>
    </div>
    <div class="card-body">

        @if ($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('registro') }}">
            @csrf

            <div class="form-group">
                <label>Nombre Completo</label>
                <input type="text" name="nombre" placeholder="Tu nombre completo" value="{{ old('nombre') }}" class="{{ $errors->has('nombre') ? 'error' : '' }}" required>
                @error('nombre') <p class="error-msg">{{ $message }}</p> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="correo" placeholder="correo@ejemplo.com" value="{{ old('correo') }}" class="{{ $errors->has('correo') ? 'error' : '' }}" required>
                    @error('correo') <p class="error-msg">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" placeholder="300-123-4567" value="{{ old('telefono') }}">
                </div>
            </div>

            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" placeholder="Calle 45 #12-34, Bogotá" value="{{ old('direccion') }}">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="contrasena" placeholder="••••••••" class="{{ $errors->has('contrasena') ? 'error' : '' }}" required>
                    @error('contrasena') <p class="error-msg">{{ $message }}</p> @enderror
                </div>
                <div class="form-group">
                    <label>Confirmar Contraseña</label>
                    <input type="password" name="contrasena_confirmation" placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" class="btn-register">Crear Cuenta</button>
        </form>

        <div class="link-login">
            ¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a>
        </div>
    </div>
</div>
</body>
</html>
