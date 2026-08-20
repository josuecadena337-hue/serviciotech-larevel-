<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multimedia — ServicioTech</title>
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

        /* CONTENIDO */
        .page-content { padding: 48px; max-width: 1200px; margin: 0 auto; }
        .section-title { text-align: center; margin-bottom: 32px; }
        .section-title h2 { font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
        .section-title p  { color: #64748b; font-size: 0.95rem; }

        /* FILTROS */
        .filter-bar { display: flex; align-items: center; gap: 10px; margin-bottom: 32px; flex-wrap: wrap; }
        .filter-bar span { font-size: 0.875rem; font-weight: 600; color: #374151; margin-right: 4px; }
        .pill-btn { padding: 7px 18px; border-radius: 20px; border: 1.5px solid #e2e8f0; background: white; color: #475569; font-size: 0.82rem; font-weight: 500; cursor: pointer; font-family: 'Inter', sans-serif; transition: all 0.2s; }
        .pill-btn:hover { border-color: #3949ab; color: #3949ab; }
        .pill-btn.active { background: #3949ab; color: white; border-color: #3949ab; font-weight: 600; }

        /* GRID */
        .media-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }

        /* CARD */
        .media-card { background: white; border-radius: 14px; overflow: hidden; border: 1px solid #e2e8f0; box-shadow: 0 2px 8px rgba(0,0,0,0.05); transition: transform 0.2s, box-shadow 0.2s; }
        .media-card:hover { transform: translateY(-4px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
        .media-card.hidden { display: none; }

        /* VIDEO THUMB */
        .video-thumb { background: #0f172a; height: 180px; display: flex; align-items: center; justify-content: center; position: relative; }
        .play-btn { width: 52px; height: 52px; background: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.2rem; box-shadow: 0 4px 16px rgba(0,0,0,0.3); }
        .duration { position: absolute; bottom: 10px; right: 12px; background: rgba(0,0,0,0.7); color: white; font-size: 0.72rem; font-weight: 600; padding: 2px 8px; border-radius: 4px; }

        /* ARTICLE THUMB */
        .article-thumb { height: 180px; display: flex; align-items: center; justify-content: center; font-size: 2.8rem; }

        /* CARD BODY */
        .card-body { padding: 16px 18px 20px; }
        .card-tags { display: flex; gap: 8px; align-items: center; margin-bottom: 10px; }
        .tag-cat { font-size: 0.7rem; font-weight: 600; color: #3949ab; }
        .tag-type { font-size: 0.7rem; font-weight: 500; color: #94a3b8; text-transform: uppercase; }
        .card-body h3 { font-size: 0.95rem; font-weight: 700; color: #0f172a; margin-bottom: 6px; line-height: 1.4; }
        .card-body p  { font-size: 0.8rem; color: #64748b; line-height: 1.6; margin-bottom: 12px; }
        .card-link { font-size: 0.82rem; font-weight: 600; color: #3949ab; text-decoration: none; transition: color 0.2s; }
        .card-link:hover { color: #1a237e; }

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
        <li><a href="{{ route('servicios') }}">Servicios</a></li>
        <li><a href="{{ route('multimedia') }}" class="active">Multimedia</a></li>
        <li><a href="{{ route('contacto') }}">Contacto</a></li>
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
        <h2>Centro de Recursos</h2>
        <p>Videos tutoriales, guías y consejos para el cuidado de tus electrodomésticos</p>
    </div>

    {{-- Filtros --}}
    <div class="filter-bar">
        <span>Filtrar por categoría:</span>
        <button class="pill-btn active" onclick="filtrar('todos', this)">Todos</button>
        <button class="pill-btn" onclick="filtrar('nevera', this)">Neveras</button>
        <button class="pill-btn" onclick="filtrar('lavadora', this)">Lavadoras</button>
        <button class="pill-btn" onclick="filtrar('aire', this)">Aires Acondicionados</button>
        <button class="pill-btn" onclick="filtrar('estufa', this)">Estufas</button>
        <button class="pill-btn" onclick="filtrar('microondas', this)">Microondas</button>
    </div>

    <div class="media-grid">

        {{-- VIDEO: Neveras --}}
        <div class="media-card" data-tipo="nevera">
            <div class="video-thumb">
                <div class="play-btn">▶</div>
                <span class="duration">5:30</span>
            </div>
            <div class="card-body">
                <div class="card-tags"><span class="tag-cat">Neveras</span><span class="tag-type">VIDEO</span></div>
                <h3>Cómo limpiar correctamente tu nevera</h3>
                <p>Aprende las técnicas correctas para mantener tu nevera limpia y funcionando óptimamente.</p>
                <a href="#" class="card-link">Ver video →</a>
            </div>
        </div>

        {{-- VIDEO: Lavadoras --}}
        <div class="media-card" data-tipo="lavadora">
            <div class="video-thumb">
                <div class="play-btn">▶</div>
                <span class="duration">7:15</span>
            </div>
            <div class="card-body">
                <div class="card-tags"><span class="tag-cat">Lavadoras</span><span class="tag-type">VIDEO</span></div>
                <h3>Mantenimiento preventivo de lavadoras</h3>
                <p>Consejos prácticos para prolongar la vida útil de tu lavadora.</p>
                <a href="#" class="card-link">Ver video →</a>
            </div>
        </div>

        {{-- VIDEO: Aires --}}
        <div class="media-card" data-tipo="aire">
            <div class="video-thumb">
                <div class="play-btn">▶</div>
                <span class="duration">10:45</span>
            </div>
            <div class="card-body">
                <div class="card-tags"><span class="tag-cat">Aires Acondicionados</span><span class="tag-type">VIDEO</span></div>
                <h3>Instalación de aire acondicionado paso a paso</h3>
                <p>Guía completa sobre el proceso de instalación de equipos de aire acondicionado.</p>
                <a href="#" class="card-link">Ver video →</a>
            </div>
        </div>

        {{-- ARTÍCULO: Neveras --}}
        <div class="media-card" data-tipo="nevera">
            <div class="article-thumb" style="background: linear-gradient(135deg, #16a34a, #22c55e);">📄</div>
            <div class="card-body">
                <div class="card-tags"><span class="tag-cat">Neveras</span><span class="tag-type">ARTÍCULO</span></div>
                <h3>10 consejos para ahorrar energía con tu nevera</h3>
                <p>Descubre cómo reducir el consumo eléctrico de tu refrigerador sin afectar su rendimiento.</p>
                <a href="#" class="card-link">Leer más →</a>
            </div>
        </div>

        {{-- CONSEJO: Lavadoras --}}
        <div class="media-card" data-tipo="lavadora">
            <div class="article-thumb" style="background: linear-gradient(135deg, #f59e0b, #fb923c);">💡</div>
            <div class="card-body">
                <div class="card-tags"><span class="tag-cat">Lavadoras</span><span class="tag-type">CONSEJO</span></div>
                <h3>Señales de que tu lavadora necesita mantenimiento</h3>
                <p>Identifica a tiempo los problemas comunes antes de que se conviertan en fallas mayores.</p>
                <a href="#" class="card-link">Leer más →</a>
            </div>
        </div>

        {{-- ARTÍCULO: Aires --}}
        <div class="media-card" data-tipo="aire">
            <div class="article-thumb" style="background: linear-gradient(135deg, #0ea5e9, #38bdf8);">📄</div>
            <div class="card-body">
                <div class="card-tags"><span class="tag-cat">Aires Acondicionados</span><span class="tag-type">ARTÍCULO</span></div>
                <h3>Frecuencia ideal de mantenimiento para aires acondicionados</h3>
                <p>Conoce cada cuánto tiempo debes hacer mantenimiento a tu equipo de aire acondicionado.</p>
                <a href="#" class="card-link">Leer más →</a>
            </div>
        </div>

        {{-- VIDEO: Estufas --}}
        <div class="media-card" data-tipo="estufa">
            <div class="video-thumb">
                <div class="play-btn">▶</div>
                <span class="duration">6:20</span>
            </div>
            <div class="card-body">
                <div class="card-tags"><span class="tag-cat">Estufas</span><span class="tag-type">VIDEO</span></div>
                <h3>Cómo limpiar los quemadores de tu estufa</h3>
                <p>Paso a paso para dejar los quemadores de tu estufa como nuevos.</p>
                <a href="#" class="card-link">Ver video →</a>
            </div>
        </div>

        {{-- CONSEJO: Estufas --}}
        <div class="media-card" data-tipo="estufa">
            <div class="article-thumb" style="background: linear-gradient(135deg, #ef4444, #f97316);">💡</div>
            <div class="card-body">
                <div class="card-tags"><span class="tag-cat">Estufas</span><span class="tag-type">CONSEJO</span></div>
                <h3>¿Tu estufa huele a gas? Esto debes hacer</h3>
                <p>Aprende qué hacer ante una posible fuga de gas en tu hogar de manera segura.</p>
                <a href="#" class="card-link">Leer más →</a>
            </div>
        </div>

        {{-- VIDEO: Microondas --}}
        <div class="media-card" data-tipo="microondas">
            <div class="video-thumb">
                <div class="play-btn">▶</div>
                <span class="duration">4:50</span>
            </div>
            <div class="card-body">
                <div class="card-tags"><span class="tag-cat">Microondas</span><span class="tag-type">VIDEO</span></div>
                <h3>Limpieza profunda de microondas en 5 minutos</h3>
                <p>Técnicas rápidas y efectivas para mantener tu microondas impecable.</p>
                <a href="#" class="card-link">Ver video →</a>
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
                <a href="#" style="color:rgba(255,255,255,0.6); text-decoration:none;">f</a>
                <a href="#" style="color:rgba(255,255,255,0.6); text-decoration:none;">ig</a>
                <a href="#" style="color:rgba(255,255,255,0.6); text-decoration:none;">tw</a>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} ServicioTech. Todos los derechos reservados.</p>
    </div>
</footer>

<script>
    function filtrar(tipo, btn) {
        document.querySelectorAll('.pill-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.media-card').forEach(card => {
            card.classList.toggle('hidden', tipo !== 'todos' && card.dataset.tipo !== tipo);
        });
    }
</script>
</body>
</html>
