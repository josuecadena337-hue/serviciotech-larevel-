<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto — ServicioTech</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: #1e293b; background: #f8fafc; }

        /* NAVBAR */
        .navbar { background: white; padding: 0 48px; display: flex; align-items: center; justify-content: space-between; height: 64px; border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 8px rgba(0,0,0,0.06); }
        .navbar-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .brand-icon { background: #1a237e; color: #f59e0b; width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .brand-text h2 { color: #1a237e; font-size: 1rem; font-weight: 700; line-height: 1.1; }
        .brand-text p  { color: #64748b; font-size: 0.68rem; }
        .navbar-links { display: flex; align-items: center; gap: 32px; list-style: none; }
        .navbar-links a { color: #475569; text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: color 0.2s; }
        .navbar-links a:hover { color: #1a237e; }
        .navbar-links a.active { color: #1a237e; font-weight: 700; }
        .navbar-actions { display: flex; gap: 10px; align-items: center; }
        .btn-login { padding: 8px 20px; border: 1.5px solid #1a237e; border-radius: 8px; color: #1a237e; background: transparent; font-size: 0.8rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: all 0.2s; }
        .btn-login:hover { background: #eff6ff; }
        .btn-register { padding: 8px 20px; background: #f59e0b; border-radius: 8px; color: white; font-size: 0.8rem; font-weight: 700; text-decoration: none; transition: all 0.2s; }
        .btn-register:hover { background: #d97706; }

        /* PÁGINA */
        .page-content { padding: 48px; max-width: 1100px; margin: 0 auto; }

        .section-title { text-align: center; margin-bottom: 40px; }
        .section-title h2 { font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
        .section-title p  { color: #64748b; font-size: 0.95rem; }

        /* DOS COLUMNAS */
        .contact-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 28px; margin-bottom: 28px; }

        /* COLUMNA IZQUIERDA */
        .info-card { background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 28px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .info-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 20px; color: #0f172a; }

        .info-item { display: flex; gap: 14px; margin-bottom: 20px; }
        .info-item:last-child { margin-bottom: 0; }
        .info-icon { width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0; }
        .icon-blue   { background: #eff6ff; }
        .icon-green  { background: #f0fdf4; }
        .icon-yellow { background: #fffbeb; }
        .icon-purple { background: #faf5ff; }
        .info-item-content h4 { font-size: 0.88rem; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
        .info-item-content p  { font-size: 0.8rem; color: #64748b; line-height: 1.6; }
        .info-item-content a  { font-size: 0.8rem; color: #3949ab; font-weight: 600; text-decoration: none; }

        /* CARD SERVICIO INMEDIATO */
        .emergency-card { background: linear-gradient(135deg, #1a237e, #3949ab); border-radius: 14px; padding: 24px 28px; color: white; }
        .emergency-card h3 { font-size: 1rem; font-weight: 700; margin-bottom: 8px; }
        .emergency-card p  { font-size: 0.82rem; color: rgba(255,255,255,0.8); line-height: 1.6; margin-bottom: 18px; }
        .btn-call { padding: 10px 22px; background: #f59e0b; color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 700; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s; }
        .btn-call:hover { background: #d97706; transform: translateY(-1px); }

        /* FORMULARIO */
        .form-card { background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 28px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .form-card h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 22px; color: #0f172a; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 0.82rem; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 0.85rem;
            font-family: 'Inter', sans-serif;
            color: #374151;
            background: white;
            transition: border-color 0.2s;
            outline: none;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus { border-color: #3949ab; }
        .form-group input::placeholder,
        .form-group textarea::placeholder { color: #94a3b8; }
        .form-group textarea { height: 120px; resize: vertical; }
        .btn-send { width: 100%; padding: 12px; background: #3949ab; color: white; border: none; border-radius: 8px; font-size: 0.9rem; font-weight: 700; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-send:hover { background: #1a237e; transform: translateY(-1px); }

        /* MAPA */
        .map-box { background: #e2e8f0; border-radius: 14px; height: 220px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; border: 1px solid #cbd5e1; margin-bottom: 60px; }
        .map-box .map-icon { font-size: 2.5rem; color: #94a3b8; }
        .map-box p { font-size: 0.9rem; font-weight: 600; color: #64748b; }
        .map-box span { font-size: 0.8rem; color: #94a3b8; }

        /* ALERTA ÉXITO */
        .alert-success { background: #dcfce7; border: 1px solid #86efac; border-radius: 8px; padding: 12px 16px; color: #166534; font-size: 0.85rem; font-weight: 600; margin-bottom: 16px; display: none; }

        /* FOOTER */
        footer { background: #1e293b; color: white; padding: 48px 48px 24px; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 48px; margin-bottom: 36px; }
        .footer-brand h3 { font-size: 1.1rem; font-weight: 700; margin-bottom: 10px; }
        .footer-brand p  { color: rgba(255,255,255,0.55); font-size: 0.82rem; line-height: 1.7; }
        .footer-col h4   { font-size: 0.9rem; font-weight: 700; margin-bottom: 16px; }
        .footer-col ul   { list-style: none; display: flex; flex-direction: column; gap: 10px; }
        .footer-col ul li { color: rgba(255,255,255,0.6); font-size: 0.82rem; display: flex; align-items: center; gap: 8px; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px; text-align: center; color: rgba(255,255,255,0.4); font-size: 0.78rem; }
    </style>
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <a href="{{ route('inicio') }}" class="navbar-brand">
        <div class="brand-icon">🔧</div>
        <div class="brand-text">
            <h2>ServicioTech</h2>
            <p>Reparación de Electrodomésticos</p>
        </div>
    </a>
    <ul class="navbar-links">
        <li><a href="{{ route('inicio') }}">Inicio</a></li>
        <li><a href="{{ route('servicios') }}">Servicios</a></li>
        <li><a href="{{ route('multimedia') }}">Multimedia</a></li>
        <li><a href="{{ route('contacto') }}" class="active">Contacto</a></li>
    </ul>
    <div class="navbar-actions">
        @guest
            <a href="{{ route('login') }}" class="btn-login">→ Iniciar Sesión</a>
            <a href="{{ route('registro') }}" class="btn-register">Registrarse</a>
        @endguest
        @auth
            <div style="display:flex; align-items:center; gap:16px;">
                <span style="font-size:0.875rem; font-weight:600; color:#475569;">
                    Hola, <strong style="color:#1a237e;">{{ Auth::user()->nombre }}</strong>
                </span>
                
                @php
                    $rol = Auth::user()->rol->nombre ?? 'cliente';
                    $ruta = $rol === 'admin' ? 'admin.dashboard' : ($rol === 'tecnico' ? 'tecnico.dashboard' : 'cliente.dashboard');
                @endphp
                
                <a href="{{ route($ruta) }}" class="btn-register" style="background:#1a237e;">Ir a mi Panel</a>
                
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-login" style="border:1px solid #ef4444; color:#ef4444; padding:7px 16px;">Cerrar sesión</button>
                </form>
            </div>
        @endauth
    </div>
</nav>

{{-- CONTENIDO --}}
<div class="page-content">

    <div class="section-title">
        <h2>Contáctanos</h2>
        <p>Estamos aquí para ayudarte. Comunícate con nosotros por cualquier medio</p>
    </div>

    <div class="contact-grid">

        {{-- COLUMNA IZQUIERDA --}}
        <div>
            <div class="info-card">
                <h3>Información de Contacto</h3>

                <div class="info-item">
                    <div class="info-icon icon-blue">📞</div>
                    <div class="info-item-content">
                        <h4>Teléfono</h4>
                        <p>+57 300 123 4567<br>+57 301 234 5678</p>
                        <a href="tel:+573001234567">Atención 24/7</a>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon icon-green">✉️</div>
                    <div class="info-item-content">
                        <h4>Correo Electrónico</h4>
                        <p>info@serviciotech.com<br>servicios@serviciotech.com</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon icon-yellow">📍</div>
                    <div class="info-item-content">
                        <h4>Dirección</h4>
                        <p>Carrera 7 #45-67<br>Bogotá, Colombia</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon icon-purple">🕐</div>
                    <div class="info-item-content">
                        <h4>Horario de Atención</h4>
                        <p>Lunes a Viernes: 8:00 AM - 6:00 PM<br>Sábados: 9:00 AM - 2:00 PM<br>Emergencias: 24/7</p>
                    </div>
                </div>
            </div>

            <div class="emergency-card">
                <h3>¿Necesitas Servicio Inmediato?</h3>
                <p>Para emergencias, llámanos directamente y tendremos un técnico en camino</p>
                <button class="btn-call" onclick="window.location='tel:+573001234567'">📞 Llamar Ahora</button>
            </div>
        </div>

        {{-- COLUMNA DERECHA: FORMULARIO --}}
        <div class="form-card">
            <h3>Envíanos un Mensaje</h3>

            <div id="alert-success" class="alert-success">
                ✅ ¡Mensaje enviado correctamente! Te contactaremos pronto.
            </div>

            <form onsubmit="enviarMensaje(event)">
                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" placeholder="Tu nombre" required>
                </div>
                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" placeholder="correo@ejemplo.com" required>
                </div>
                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="tel" placeholder="300-123-4567">
                </div>
                <div class="form-group">
                    <label>Asunto</label>
                    <select required>
                        <option value="">Seleccionar...</option>
                        <option>Solicitar una reparación</option>
                        <option>Consulta sobre precios</option>
                        <option>Estado de mi solicitud</option>
                        <option>Queja o sugerencia</option>
                        <option>Otro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Mensaje</label>
                    <textarea placeholder="Escribe tu mensaje aquí..." required></textarea>
                </div>
                <button type="submit" class="btn-send">✈️ Enviar Mensaje</button>
            </form>
        </div>
    </div>

    {{-- MAPA --}}
    <div class="map-box">
        <div class="map-icon">📍</div>
        <p>Mapa de ubicación</p>
        <span>Carrera 7 #45-67, Bogotá</span>
    </div>

</div>

{{-- FOOTER --}}
<footer>
    <div class="footer-grid">
        <div class="footer-brand">
            <h3>ServicioTech</h3>
            <p>Especialistas en reparación y mantenimiento de electrodomésticos. Servicio profesional y garantizado.</p>
        </div>
        <div class="footer-col">
            <h4>Contacto</h4>
            <ul>
                <li>📞 +57 300 123 4567</li>
                <li>✉️ info@serviciotech.com</li>
                <li>📍 Bogotá, Colombia</li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Síguenos</h4>
            <div style="display:flex; gap:16px; margin-top:4px;">
                <a href="#" style="color:rgba(255,255,255,0.6); text-decoration:none; font-size:1.1rem;">f</a>
                <a href="#" style="color:rgba(255,255,255,0.6); text-decoration:none; font-size:1.1rem;">ig</a>
                <a href="#" style="color:rgba(255,255,255,0.6); text-decoration:none; font-size:1.1rem;">tw</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} ServicioTech. Todos los derechos reservados.</p>
    </div>
</footer>

<script>
    function enviarMensaje(e) {
        e.preventDefault();
        const alert = document.getElementById('alert-success');
        alert.style.display = 'block';
        e.target.reset();
        setTimeout(() => { alert.style.display = 'none'; }, 5000);
    }
</script>
</body>
</html>
