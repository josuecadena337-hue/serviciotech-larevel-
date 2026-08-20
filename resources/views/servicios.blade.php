<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios — ServicioTech</title>
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
        .btn-register { padding: 8px 20px; background: #f59e0b; border: none; border-radius: 8px; color: white; font-size: 0.8rem; font-weight: 700; text-decoration: none; transition: all 0.2s; }
        .btn-register:hover { background: #d97706; }

        /* CONTENIDO */
        .page-content { padding: 48px; max-width: 1100px; margin: 0 auto; }

        .section-title { text-align: center; margin-bottom: 32px; }
        .section-title h2 { font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
        .section-title p  { color: #64748b; font-size: 0.95rem; }

        /* FILTROS */
        .filter-box { border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px 24px; margin-bottom: 32px; background: white; box-shadow: 0 1px 4px rgba(0,0,0,0.04); }
        .filter-label { font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 14px; }
        .filters { display: flex; gap: 10px; flex-wrap: wrap; }
        .filter-btn { display: flex; flex-direction: column; align-items: center; gap: 5px; padding: 12px 18px; border: 1.5px solid #e2e8f0; border-radius: 10px; background: white; color: #475569; font-size: 0.8rem; font-weight: 500; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s; min-width: 85px; }
        .filter-btn .f-icon { font-size: 1.5rem; }
        .filter-btn:hover { border-color: #3949ab; color: #3949ab; }
        .filter-btn.active { border-color: #3949ab; color: #3949ab; background: #eff4ff; font-weight: 700; }

        /* CARDS DE SERVICIOS */
        .services-list { display: flex; flex-direction: column; gap: 24px; }
        .service-card { border: 1px solid #e2e8f0; border-radius: 14px; overflow: hidden; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
        .service-card-header { background: #3949ab; color: white; padding: 16px 24px; font-size: 1.05rem; font-weight: 700; }
        .service-card-body { padding: 24px; display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
        .service-col h4 { font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; display: flex; align-items: center; gap: 7px; }
        .service-col .desc { color: #475569; font-size: 0.82rem; line-height: 1.6; margin-bottom: 12px; }
        .preventivo-list { list-style: none; display: flex; flex-direction: column; gap: 7px; }
        .preventivo-list li { font-size: 0.82rem; color: #3949ab; display: flex; align-items: center; gap: 6px; }
        .preventivo-list li::before { content: '✓'; color: #3949ab; font-weight: 700; }
        .correctivo-list { list-style: none; display: flex; flex-direction: column; gap: 7px; }
        .correctivo-list li { font-size: 0.82rem; color: #374151; display: flex; align-items: center; gap: 6px; }
        .correctivo-list li::before { content: '•'; color: #f59e0b; font-size: 1rem; }
        .correctivo-subtitle { font-size: 0.82rem; color: #374151; margin-bottom: 10px; }
        .special-note { background: #fffbeb; border: 1px solid #fde68a; border-radius: 8px; padding: 10px 14px; font-size: 0.82rem; color: #92400e; display: flex; align-items: center; gap: 6px; margin: 0 24px 0; }
        .service-card-footer { padding: 18px 24px; border-top: 1px solid #f1f5f9; }
        .btn-service { padding: 10px 22px; background: #3949ab; color: white; border: none; border-radius: 8px; font-size: 0.85rem; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; text-decoration: none; display: inline-block; transition: all 0.2s; }
        .btn-service:hover { background: #1a237e; transform: translateY(-1px); }
        .service-item.hidden { display: none; }

        /* FOOTER */
        footer { background: #1e293b; color: white; padding: 48px 48px 24px; margin-top: 60px; }
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
        <li><a href="{{ route('servicios') }}" class="active">Servicios</a></li>
        <li><a href="{{ route('multimedia') }}">Multimedia</a></li>
        <li><a href="#">Contacto</a></li>
    </ul>
    <div class="navbar-actions">
        <a href="{{ route('login') }}" class="btn-login">→ Iniciar Sesión</a>
        <a href="{{ route('registro') }}" class="btn-register">Registrarse</a>
    </div>
</nav>

{{-- CONTENIDO --}}
<div class="page-content">

    <div class="section-title">
        <h2>Nuestros Servicios</h2>
        <p>Servicio técnico especializado por tipo de electrodoméstico</p>
    </div>

    {{-- Filtros --}}
    <div class="filter-box">
        <p class="filter-label">Filtrar por Electrodoméstico:</p>
        <div class="filters">
            <button class="filter-btn active" onclick="filtrar('todos', this)">
                <span class="f-icon">🔧</span>Todos
            </button>
            <button class="filter-btn" onclick="filtrar('nevera', this)">
                <span class="f-icon">❄️</span>Neveras
            </button>
            <button class="filter-btn" onclick="filtrar('lavadora', this)">
                <span class="f-icon">⚡</span>Lavadoras
            </button>
            <button class="filter-btn" onclick="filtrar('aire', this)">
                <span class="f-icon">💨</span>Aires Acondicionados
            </button>
            <button class="filter-btn" onclick="filtrar('estufa', this)">
                <span class="f-icon">🍳</span>Estufas
            </button>
            <button class="filter-btn" onclick="filtrar('microondas', this)">
                <span class="f-icon">📡</span>Microondas
            </button>
            <button class="filter-btn" onclick="filtrar('televisor', this)">
                <span class="f-icon">📺</span>Televisores
            </button>
        </div>
    </div>

    {{-- Cards --}}
    <div class="services-list">

        {{-- Neveras --}}
        <div class="service-card service-item" data-tipo="nevera">
            <div class="service-card-header">Reparación de Neveras</div>
            <div class="service-card-body">
                <div class="service-col">
                    <h4><span style="color:#16a34a; font-size:1rem;">●</span> Mantenimiento Preventivo</h4>
                    <p class="desc">Mantén tu electrodoméstico funcionando de manera óptima con nuestro servicio preventivo:</p>
                    <ul class="preventivo-list">
                        <li>Limpieza de condensador y serpentines</li>
                        <li>Revisión de termostato y temperatura</li>
                        <li>Verificación de empaques de puertas</li>
                        <li>Limpieza de drenaje</li>
                    </ul>
                </div>
                <div class="service-col">
                    <h4><span style="color:#f59e0b; font-size:1rem;">●</span> Mantenimiento Correctivo</h4>
                    <p class="correctivo-subtitle">Reparamos las <span style="color:#ea580c;">fallas</span> más comunes:</p>
                    <ul class="correctivo-list">
                        <li>No enfría adecuadamente</li>
                        <li>Ruidos o vibraciones anormales</li>
                        <li>Fuga de agua</li>
                        <li>Compresor no enciende</li>
                    </ul>
                </div>
            </div>
            <div class="service-card-footer">
                <a href="{{ route('registro') }}" class="btn-service">Solicitar este Servicio</a>
            </div>
        </div>

        {{-- Lavadoras --}}
        <div class="service-card service-item" data-tipo="lavadora">
            <div class="service-card-header">Reparación de Lavadoras</div>
            <div class="service-card-body">
                <div class="service-col">
                    <h4><span style="color:#16a34a; font-size:1rem;">●</span> Mantenimiento Preventivo</h4>
                    <p class="desc">Mantén tu electrodoméstico funcionando de manera óptima con nuestro servicio preventivo:</p>
                    <ul class="preventivo-list">
                        <li>Limpieza de filtros y mangueras</li>
                        <li>Revisión de sistema de drenaje</li>
                        <li>Inspección de tambor y rodamientos</li>
                        <li>Calibración de carga</li>
                    </ul>
                </div>
                <div class="service-col">
                    <h4><span style="color:#f59e0b; font-size:1rem;">●</span> Mantenimiento Correctivo</h4>
                    <p class="correctivo-subtitle">Reparamos las <span style="color:#ea580c;">fallas</span> más comunes:</p>
                    <ul class="correctivo-list">
                        <li>No centrifuga correctamente</li>
                        <li>Fugas de agua</li>
                        <li>No enciende o no gira</li>
                        <li>Ruido excesivo al lavar</li>
                    </ul>
                </div>
            </div>
            <div class="service-card-footer">
                <a href="{{ route('registro') }}" class="btn-service">Solicitar este Servicio</a>
            </div>
        </div>

        {{-- Aires --}}
        <div class="service-card service-item" data-tipo="aire">
            <div class="service-card-header">Aires Acondicionados</div>
            <div class="service-card-body">
                <div class="service-col">
                    <h4><span style="color:#16a34a; font-size:1rem;">●</span> Mantenimiento Preventivo</h4>
                    <p class="desc">Mantén tu electrodoméstico funcionando de manera óptima con nuestro servicio preventivo:</p>
                    <ul class="preventivo-list">
                        <li>Limpieza de filtros y serpentines</li>
                        <li>Recarga de gas refrigerante</li>
                        <li>Revisión de sistema eléctrico</li>
                        <li>Verificación de drenaje</li>
                    </ul>
                </div>
                <div class="service-col">
                    <h4><span style="color:#f59e0b; font-size:1rem;">●</span> Mantenimiento Correctivo</h4>
                    <p class="correctivo-subtitle">Reparamos las <span style="color:#ea580c;">fallas</span> más comunes:</p>
                    <ul class="correctivo-list">
                        <li>No enfría adecuadamente</li>
                        <li>Goteo de agua</li>
                        <li>Ruido anormal en funcionamiento</li>
                        <li>No enciende</li>
                    </ul>
                </div>
            </div>
            <div class="special-note" style="margin-bottom:0;">
                ⭐ <strong>Servicio Especial:</strong> Instalación y desmontaje de equipos
            </div>
            <div class="service-card-footer">
                <a href="{{ route('registro') }}" class="btn-service">Solicitar este Servicio</a>
            </div>
        </div>

        {{-- Estufas --}}
        <div class="service-card service-item" data-tipo="estufa">
            <div class="service-card-header">Reparación de Estufas</div>
            <div class="service-card-body">
                <div class="service-col">
                    <h4><span style="color:#16a34a; font-size:1rem;">●</span> Mantenimiento Preventivo</h4>
                    <p class="desc">Mantén tu electrodoméstico funcionando de manera óptima con nuestro servicio preventivo:</p>
                    <ul class="preventivo-list">
                        <li>Limpieza de quemadores</li>
                        <li>Revisión de válvulas de gas</li>
                        <li>Calibración de temperatura del horno</li>
                        <li>Inspección de sistema eléctrico</li>
                    </ul>
                </div>
                <div class="service-col">
                    <h4><span style="color:#f59e0b; font-size:1rem;">●</span> Mantenimiento Correctivo</h4>
                    <p class="correctivo-subtitle">Reparamos las <span style="color:#ea580c;">fallas</span> más comunes:</p>
                    <ul class="correctivo-list">
                        <li>Hornillas no encienden</li>
                        <li>Horno no calienta</li>
                        <li>Fuga de gas</li>
                        <li>Encendido defectuoso</li>
                    </ul>
                </div>
            </div>
            <div class="service-card-footer">
                <a href="{{ route('registro') }}" class="btn-service">Solicitar este Servicio</a>
            </div>
        </div>

        {{-- Microondas --}}
        <div class="service-card service-item" data-tipo="microondas">
            <div class="service-card-header">Reparación de Microondas</div>
            <div class="service-card-body">
                <div class="service-col">
                    <h4><span style="color:#16a34a; font-size:1rem;">●</span> Mantenimiento Preventivo</h4>
                    <p class="desc">Mantén tu electrodoméstico funcionando de manera óptima con nuestro servicio preventivo:</p>
                    <ul class="preventivo-list">
                        <li>Limpieza interna y externa</li>
                        <li>Revisión de magnetrón</li>
                        <li>Verificación de puertas y sellos</li>
                        <li>Revisión del panel de control</li>
                    </ul>
                </div>
                <div class="service-col">
                    <h4><span style="color:#f59e0b; font-size:1rem;">●</span> Mantenimiento Correctivo</h4>
                    <p class="correctivo-subtitle">Reparamos las <span style="color:#ea580c;">fallas</span> más comunes:</p>
                    <ul class="correctivo-list">
                        <li>No calienta los alimentos</li>
                        <li>Hace ruidos extraños</li>
                        <li>Plato no gira</li>
                        <li>Panel no responde</li>
                    </ul>
                </div>
            </div>
            <div class="service-card-footer">
                <a href="{{ route('registro') }}" class="btn-service">Solicitar este Servicio</a>
            </div>
        </div>

        {{-- Televisores --}}
        <div class="service-card service-item" data-tipo="televisor">
            <div class="service-card-header">Reparación de Televisores</div>
            <div class="service-card-body">
                <div class="service-col">
                    <h4><span style="color:#16a34a; font-size:1rem;">●</span> Mantenimiento Preventivo</h4>
                    <p class="desc">Mantén tu electrodoméstico funcionando de manera óptima con nuestro servicio preventivo:</p>
                    <ul class="preventivo-list">
                        <li>Limpieza de pantalla y ventilación</li>
                        <li>Revisión de fuente de poder</li>
                        <li>Actualización de firmware</li>
                        <li>Revisión de conectores</li>
                    </ul>
                </div>
                <div class="service-col">
                    <h4><span style="color:#f59e0b; font-size:1rem;">●</span> Mantenimiento Correctivo</h4>
                    <p class="correctivo-subtitle">Reparamos las <span style="color:#ea580c;">fallas</span> más comunes:</p>
                    <ul class="correctivo-list">
                        <li>No enciende</li>
                        <li>Pantalla con líneas o manchas</li>
                        <li>Sin imagen pero con audio</li>
                        <li>Se apaga solo</li>
                    </ul>
                </div>
            </div>
            <div class="service-card-footer">
                <a href="{{ route('registro') }}" class="btn-service">Solicitar este Servicio</a>
            </div>
        </div>

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
    function filtrar(tipo, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.service-item').forEach(card => {
            card.classList.toggle('hidden', tipo !== 'todos' && card.dataset.tipo !== tipo);
        });
    }
</script>
</body>
</html>
