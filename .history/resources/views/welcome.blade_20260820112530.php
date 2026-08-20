<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServicioTech — Reparación de Electrodomésticos</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; color: #1e293b; background: #f8fafc; }

        /* ── NAVBAR ── */
        .navbar { background: white; padding: 0 48px; display: flex; align-items: center; justify-content: space-between; height: 64px; border-bottom: 1px solid #e2e8f0; position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 8px rgba(0,0,0,0.06); }
        .navbar-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .brand-icon { background: #1a237e; color: #f59e0b; width: 36px; height: 36px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; }
        .brand-text h2 { color: #1a237e; font-size: 1rem; font-weight: 700; line-height: 1.1; }
        .brand-text p  { color: #64748b; font-size: 0.68rem; }
        .navbar-links { display: flex; align-items: center; gap: 32px; list-style: none; }
        .navbar-links a { color: #475569; text-decoration: none; font-size: 0.875rem; font-weight: 500; transition: color 0.2s; }
        .navbar-links a:hover { color: #1a237e; }
        .navbar-actions { display: flex; gap: 10px; align-items: center; }
        .btn-login { padding: 8px 20px; border: 1.5px solid #1a237e; border-radius: 8px; color: #1a237e; background: transparent; font-size: 0.8rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px; transition: all 0.2s; }
        .btn-login:hover { background: #eff6ff; }
        .btn-register { padding: 8px 20px; background: #f59e0b; border: none; border-radius: 8px; color: white; font-size: 0.8rem; font-weight: 700; text-decoration: none; transition: all 0.2s; }
        .btn-register:hover { background: #d97706; }

        /* ── HERO ── */
        .hero { background: linear-gradient(135deg, #1a237e 0%, #3949ab 60%, #5c6bc0 100%); padding: 80px 48px; display: grid; grid-template-columns: 1fr 1fr; gap: 60px; align-items: center; }
        .hero-content h1 { color: white; font-size: 2.6rem; font-weight: 800; line-height: 1.2; margin-bottom: 16px; }
        .hero-content p  { color: rgba(255,255,255,0.85); font-size: 1rem; line-height: 1.7; margin-bottom: 28px; }
        .hero-buttons { display: flex; gap: 14px; }
        .btn-hero-primary { padding: 12px 28px; background: #f59e0b; color: white; font-weight: 700; font-size: 0.9rem; border-radius: 8px; text-decoration: none; transition: all 0.2s; }
        .btn-hero-primary:hover { background: #d97706; transform: translateY(-1px); }
        .btn-hero-secondary { padding: 12px 28px; background: transparent; color: white; font-weight: 600; font-size: 0.9rem; border-radius: 8px; text-decoration: none; border: 2px solid rgba(255,255,255,0.5); transition: all 0.2s; }
        .btn-hero-secondary:hover { border-color: white; background: rgba(255,255,255,0.1); }
        .hero-image { background: rgba(255,255,255,0.1); border-radius: 16px; height: 280px; display: flex; align-items: center; justify-content: center; font-size: 5rem; border: 1px solid rgba(255,255,255,0.2); }

        /* ── POR QUÉ ELEGIRNOS ── */
        .features { padding: 64px 48px; background: white; }
        .section-title { text-align: center; margin-bottom: 40px; }
        .section-title h2 { font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 8px; }
        .section-title p  { color: #64748b; font-size: 0.95rem; }
        .features-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 20px; max-width: 1100px; margin: 0 auto; }
        .feature-card { background: #f8fafc; border-radius: 14px; padding: 28px 20px; text-align: center; border: 1px solid #e2e8f0; transition: all 0.2s; }
        .feature-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .feature-icon { width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin: 0 auto 14px; }
        .feature-card h3 { font-size: 0.95rem; font-weight: 700; margin-bottom: 8px; color: #0f172a; }
        .feature-card p  { font-size: 0.8rem; color: #64748b; line-height: 1.6; }

        /* ── FOOTER ── */
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
        <li><a href="{{ route('contacto') }}">Contacto</a></li>
    </ul>
    <div class="navbar-actions">
        <a href="{{ route('login') }}" class="btn-login">→ Iniciar Sesión</a>
        <a href="{{ route('registro') }}" class="btn-register">Registrarse</a>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-content">
        <h1>Reparación y Mantenimiento de Electrodomésticos</h1>
        <p>Servicio técnico profesional para todos tus electrodomésticos. Rápido, confiable y con garantía de 90 días.</p>
        <div class="hero-buttons">
            <a href="{{ route('registro') }}" class="btn-hero-primary">Solicitar Servicio</a>
            <a href="{{ route('login') }}" class="btn-hero-secondary">Iniciar Sesión</a>
        </div>
    </div>
    <div class="hero-image">
    <img src="{{ asset('imagenes/hero_fridge.jpg') }}" alt="ServicioTech" style="width:100%; height:100%; object-fit:cover; border-radius:12px;">
    </div>
</section>

{{-- ¿POR QUÉ ELEGIRNOS? --}}
<section class="features">
    <div class="section-title">
        <h2>¿Por Qué Elegirnos?</h2>
        <p>Comprometidos con la calidad y satisfacción de nuestros clientes</p>
    </div>
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon" style="background:#eff6ff;">🔧</div>
            <h3>Técnicos Certificados</h3>
            <p>Personal altamente capacitado y con experiencia en todo tipo de electrodomésticos</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background:#f0fdf4;">🛡️</div>
            <h3>Garantía Total</h3>
            <p>Todos nuestros servicios incluyen garantía de 90 días en reparaciones</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background:#fffbeb;">⏰</div>
            <h3>Atención Rápida</h3>
            <p>Servicio de emergencia disponible 24/7 para resolver tus problemas</p>
        </div>
        <div class="feature-card">
            <div class="feature-icon" style="background:#faf5ff;">👍</div>
            <h3>Clientes Satisfechos</h3>
            <p>Más de 5,000 clientes satisfechos confían en nuestro servicio</p>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer id="contacto">
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
            <div style="display:flex; gap:14px; margin-top:4px;">
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

</body>
</html>
