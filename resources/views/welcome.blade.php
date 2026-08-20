<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ServicioTech — Especialistas en reparación y mantenimiento de electrodomésticos. Servicio profesional y garantizado en Bogotá, Colombia.">
    <title>ServicioTech — Reparación de Electrodomésticos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            color: #1e293b;
            background: #f8fafc;
        }

        /* ── NAVBAR ─────────────────────────────────── */
        .navbar {
            background: #1a237e;
            padding: 0 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 12px rgba(0,0,0,0.2);
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .navbar-brand .logo-icon {
            font-size: 1.5rem;
        }

        .navbar-brand .brand-text h2 {
            color: white;
            font-size: 1.1rem;
            font-weight: 700;
            line-height: 1.1;
        }

        .navbar-brand .brand-text p {
            color: rgba(255,255,255,0.65);
            font-size: 0.7rem;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .navbar-links a {
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.2s;
        }

        .navbar-links a:hover { color: white; }

        .navbar-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-login {
            padding: 9px 22px;
            border: 1.5px solid rgba(255,255,255,0.5);
            border-radius: 8px;
            color: white;
            background: transparent;
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
        }

        .btn-login:hover {
            background: rgba(255,255,255,0.1);
            border-color: white;
        }

        .btn-register {
            padding: 9px 22px;
            background: #f59e0b;
            border: none;
            border-radius: 8px;
            color: #1a237e;
            font-size: 0.875rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-register:hover {
            background: #fbbf24;
            transform: translateY(-1px);
        }

        /* ── HERO ────────────────────────────────────── */
        .hero {
            background: linear-gradient(135deg, #1a237e 0%, #3949ab 60%, #5c6bc0 100%);
            padding: 80px 48px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: center;
            min-height: 520px;
        }

        .hero-content h1 {
            color: white;
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .hero-content p {
            color: rgba(255,255,255,0.85);
            font-size: 1.1rem;
            line-height: 1.7;
            margin-bottom: 36px;
            max-width: 480px;
        }

        .hero-buttons {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
        }

        .btn-hero-primary {
            padding: 14px 32px;
            background: #f59e0b;
            color: #1a237e;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-hero-primary:hover {
            background: #fbbf24;
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(245,158,11,0.4);
        }

        .btn-hero-secondary {
            padding: 14px 32px;
            background: transparent;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            text-decoration: none;
            border: 2px solid rgba(255,255,255,0.5);
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .btn-hero-secondary:hover {
            border-color: white;
            background: rgba(255,255,255,0.1);
        }

        .hero-image {
            border-radius: 16px;
            overflow: hidden;
            height: 360px;
            background: linear-gradient(135deg, #334155, #475569);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 6rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        /* ── POR QUÉ ELEGIRNOS ───────────────────────── */
        .section { padding: 80px 48px; }
        .section-white { background: white; }
        .section-gray  { background: #f8fafc; }

        .section-title {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title h2 {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 10px;
        }

        .section-title p {
            color: #64748b;
            font-size: 1rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .feature-card {
            background: white;
            border-radius: 14px;
            padding: 30px 24px;
            text-align: center;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.6rem;
            margin: 0 auto 16px;
        }

        .icon-azul   { background: #eff6ff; }
        .icon-verde  { background: #f0fdf4; }
        .icon-amarillo { background: #fffbeb; }
        .icon-morado { background: #faf5ff; }

        .feature-card h3 {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .feature-card p {
            font-size: 0.875rem;
            color: #64748b;
            line-height: 1.6;
        }

        /* ── SERVICIOS ───────────────────────────────── */
        .services-filter {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 36px;
            max-width: 1100px;
            margin-left: auto;
            margin-right: auto;
        }

        .filter-btn {
            padding: 10px 20px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            background: white;
            color: #64748b;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            min-width: 90px;
        }

        .filter-btn .filter-icon { font-size: 1.4rem; }
        .filter-btn.active { border-color: #3949ab; color: #3949ab; background: #eff6ff; font-weight: 600; }
        .filter-btn:hover { border-color: #3949ab; color: #3949ab; }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .service-card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .service-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }

        .service-header {
            background: linear-gradient(135deg, #1a237e, #3949ab);
            color: white;
            padding: 18px 22px;
            font-size: 1.05rem;
            font-weight: 700;
        }

        .service-body { padding: 22px; }

        .service-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .service-type h4 {
            font-size: 0.875rem;
            font-weight: 700;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .dot-green { color: #16a34a; }
        .dot-orange { color: #f59e0b; }

        .service-type ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .service-type ul li {
            font-size: 0.8rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .service-type ul li::before { content: '✓'; color: #16a34a; font-weight: bold; font-size: 0.75rem; }
        .service-type.correctivo ul li::before { content: '•'; color: #f59e0b; }

        .btn-service {
            display: block;
            width: 100%;
            margin-top: 18px;
            padding: 11px;
            background: #1a237e;
            color: white;
            border: none;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-service:hover { background: #3949ab; transform: translateY(-1px); }

        /* ── CTA ─────────────────────────────────────── */
        .cta-section {
            background: linear-gradient(135deg, #3949ab, #5c6bc0);
            padding: 70px 48px;
            text-align: center;
        }

        .cta-section h2 {
            color: white;
            font-size: 2.2rem;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .cta-section p {
            color: rgba(255,255,255,0.85);
            font-size: 1rem;
            margin-bottom: 32px;
        }

        .cta-buttons { display: flex; gap: 16px; justify-content: center; }

        .btn-cta-primary {
            padding: 14px 32px;
            background: #f59e0b;
            color: #1a237e;
            font-weight: 700;
            font-size: 1rem;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .btn-cta-primary:hover { background: #fbbf24; transform: translateY(-2px); }

        .btn-cta-secondary {
            padding: 14px 32px;
            background: transparent;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            border-radius: 10px;
            text-decoration: none;
            border: 2px solid rgba(255,255,255,0.6);
            cursor: pointer;
            font-family: 'Inter', sans-serif;
            transition: all 0.2s;
        }

        .btn-cta-secondary:hover { border-color: white; background: rgba(255,255,255,0.1); }

        /* ── FOOTER ──────────────────────────────────── */
        footer {
            background: #0f172a;
            color: white;
            padding: 50px 48px 24px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 48px;
            margin-bottom: 40px;
        }

        .footer-brand h3 {
            font-size: 1.2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .footer-brand p {
            color: rgba(255,255,255,0.6);
            font-size: 0.875rem;
            line-height: 1.7;
        }

        .footer-col h4 {
            font-size: 0.9rem;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 8px; }
        .footer-col ul li { color: rgba(255,255,255,0.6); font-size: 0.875rem; display: flex; align-items: center; gap: 8px; }

        .social-icons { display: flex; gap: 14px; margin-top: 10px; }
        .social-icons a { color: rgba(255,255,255,0.6); font-size: 1.2rem; text-decoration: none; transition: color 0.2s; }
        .social-icons a:hover { color: white; }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 20px;
            text-align: center;
            color: rgba(255,255,255,0.4);
            font-size: 0.8rem;
        }
    </style>
</head>
<body>

{{-- ─── NAVBAR ─────────────────────────────────────────── --}}
<nav class="navbar">
    <a href="{{ route('inicio') }}" class="navbar-brand">
        <span class="logo-icon">🔧</span>
        <div class="brand-text">
            <h2>ServicioTech</h2>
            <p>Reparación de Electrodomésticos</p>
        </div>
    </a>

    <ul class="navbar-links">
        <li><a href="#inicio">Inicio</a></li>
        <li><a href="#servicios">Servicios</a></li>
        <li><a href="#multimedia">Multimedia</a></li>
        <li><a href="#contacto">Contacto</a></li>
    </ul>

    <div class="navbar-actions">
        <a href="{{ route('login') }}" class="btn-login">→ Iniciar Sesión</a>
        <a href="{{ route('registro') }}" class="btn-register">Registrarse</a>
    </div>
</nav>

{{-- ─── HERO ────────────────────────────────────────────── --}}
<section class="hero" id="inicio">
    <div class="hero-content">
        <h1>Reparación y Mantenimiento de Electrodomésticos</h1>
        <p>Servicio técnico profesional para todos tus electrodomésticos. Rápido, confiable y con garantía.</p>
        <div class="hero-buttons">
            <a href="{{ route('registro') }}" class="btn-hero-primary">Solicitar Servicio →</a>
            <a href="#servicios" class="btn-hero-secondary">Ver Servicios</a>
        </div>
    </div>
    <div class="hero-image">🏠</div>
</section>

{{-- ─── ¿POR QUÉ ELEGIRNOS? ────────────────────────────── --}}
<section class="section section-white">
    <div class="section-title">
        <h2>¿Por Qué Elegirnos?</h2>
        <p>Comprometidos con la calidad y satisfacción de nuestros clientes</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon icon-azul">🔧</div>
            <h3>Técnicos Certificados</h3>
            <p>Personal altamente capacitado y con experiencia en todo tipo de electrodomésticos</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon icon-verde">🛡️</div>
            <h3>Garantía Total</h3>
            <p>Todos nuestros servicios incluyen garantía de 90 días en reparaciones</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon icon-amarillo">⏰</div>
            <h3>Atención Rápida</h3>
            <p>Servicio de emergencia disponible 24/7 para resolver tus problemas</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon icon-morado">👍</div>
            <h3>Clientes Satisfechos</h3>
            <p>Más de 5,000 clientes satisfechos confían en nuestro servicio</p>
        </div>
    </div>
</section>

{{-- ─── NUESTROS SERVICIOS ──────────────────────────────── --}}
<section class="section section-gray" id="servicios">
    <div class="section-title">
        <h2>Nuestros Servicios</h2>
        <p>Servicio técnico especializado por tipo de electrodoméstico</p>
    </div>

    <div class="services-filter">
        <button class="filter-btn active">
            <span class="filter-icon">🔧</span> Todos
        </button>
        <button class="filter-btn">
            <span class="filter-icon">❄️</span> Neveras
        </button>
        <button class="filter-btn">
            <span class="filter-icon">⚡</span> Lavadoras
        </button>
        <button class="filter-btn">
            <span class="filter-icon">💨</span> Aires
        </button>
        <button class="filter-btn">
            <span class="filter-icon">🍳</span> Estufas
        </button>
        <button class="filter-btn">
            <span class="filter-icon">📡</span> Microondas
        </button>
        <button class="filter-btn">
            <span class="filter-icon">📺</span> Televisores
        </button>
    </div>

    <div class="services-grid">
        {{-- Neveras --}}
        <div class="service-card">
            <div class="service-header">❄️ Reparación de Neveras</div>
            <div class="service-body">
                <div class="service-row">
                    <div class="service-type">
                        <h4><span class="dot-green">●</span> Mant. Preventivo</h4>
                        <ul>
                            <li>Limpieza de condensador</li>
                            <li>Revisión de termostato</li>
                            <li>Verificación de empaques</li>
                            <li>Limpieza de drenaje</li>
                        </ul>
                    </div>
                    <div class="service-type correctivo">
                        <h4><span class="dot-orange">●</span> Mant. Correctivo</h4>
                        <ul>
                            <li>No enfría adecuadamente</li>
                            <li>Ruidos o vibraciones</li>
                            <li>Fuga de agua</li>
                            <li>Compresor no enciende</li>
                        </ul>
                    </div>
                </div>
                <a href="{{ route('registro') }}" class="btn-service">Solicitar este Servicio</a>
            </div>
        </div>

        {{-- Lavadoras --}}
        <div class="service-card">
            <div class="service-header">⚡ Reparación de Lavadoras</div>
            <div class="service-body">
                <div class="service-row">
                    <div class="service-type">
                        <h4><span class="dot-green">●</span> Mant. Preventivo</h4>
                        <ul>
                            <li>Limpieza de filtros</li>
                            <li>Revisión de drenaje</li>
                            <li>Inspección de tambor</li>
                            <li>Calibración de carga</li>
                        </ul>
                    </div>
                    <div class="service-type correctivo">
                        <h4><span class="dot-orange">●</span> Mant. Correctivo</h4>
                        <ul>
                            <li>No centrifuga bien</li>
                            <li>Fugas de agua</li>
                            <li>No enciende o gira</li>
                            <li>Ruido excesivo</li>
                        </ul>
                    </div>
                </div>
                <a href="{{ route('registro') }}" class="btn-service">Solicitar este Servicio</a>
            </div>
        </div>

        {{-- Aires --}}
        <div class="service-card">
            <div class="service-header">💨 Aires Acondicionados</div>
            <div class="service-body">
                <div class="service-row">
                    <div class="service-type">
                        <h4><span class="dot-green">●</span> Mant. Preventivo</h4>
                        <ul>
                            <li>Limpieza de filtros</li>
                            <li>Recarga de gas</li>
                            <li>Revisión eléctrica</li>
                            <li>Verificación de drenaje</li>
                        </ul>
                    </div>
                    <div class="service-type correctivo">
                        <h4><span class="dot-orange">●</span> Mant. Correctivo</h4>
                        <ul>
                            <li>No enfría bien</li>
                            <li>Goteo de agua</li>
                            <li>Ruido anormal</li>
                            <li>No enciende</li>
                        </ul>
                    </div>
                </div>
                <a href="{{ route('registro') }}" class="btn-service">Solicitar este Servicio</a>
            </div>
        </div>
    </div>
</section>

{{-- ─── CTA ─────────────────────────────────────────────── --}}
<section class="cta-section">
    <h2>¿Necesitas Ayuda Ahora?</h2>
    <p>Solicita tu servicio en línea o contáctanos para una atención inmediata</p>
    <div class="cta-buttons">
        <a href="{{ route('registro') }}" class="btn-cta-primary">Solicitar Servicio</a>
        <a href="#contacto" class="btn-cta-secondary">Contáctanos</a>
    </div>
</section>

{{-- ─── FOOTER ──────────────────────────────────────────── --}}
<footer id="contacto">
    <div class="footer-grid">
        <div class="footer-brand">
            <h3>🔧 ServicioTech</h3>
            <p>Especialistas en reparación y mantenimiento de electrodomésticos. Servicio profesional y garantizado.</p>
            <div class="social-icons">
                <a href="#">📘</a>
                <a href="#">📷</a>
                <a href="#">🐦</a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Contacto</h4>
            <ul>
                <li>📞 +57 300 123 4567</li>
                <li>✉️ info@serviciotech.com</li>
                <li>📍 Bogotá, Colombia</li>
                <li>🕐 Lun-Vie: 8AM - 6PM</li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Síguenos</h4>
            <ul>
                <li>Facebook</li>
                <li>Instagram</li>
                <li>Twitter</li>
                <li>YouTube</li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© {{ date('Y') }} ServicioTech. Todos los derechos reservados.</p>
    </div>
</footer>

<script>
    // Filtros de servicios (funcionalidad básica)
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });
</script>

</body>
</html>
