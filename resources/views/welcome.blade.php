@extends('layouts.app')

@section('content')
<style>
    /* ============================================ */
    /* HERO SECTION (Original)                      */
    /* ============================================ */
    .hero-section {
        padding: 4rem 0;
    }

    .hero-visual {
        position: relative;
        min-height: 40vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-main {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 320px;
        filter: drop-shadow(0 20px 30px rgba(0,0,0,0.5));
        transition: transform 0.3s ease;
    }

    .hero-main:hover {
        transform: scale(1.02);
    }

    .hero-bg-left {
        position: absolute;
        left: -10px;
        top: 50%;
        transform: translateY(-50%);
        width: 140px;
        opacity: 0.4;
        z-index: 1;
        filter: blur(3px);
        pointer-events: none;
        animation: floatLeft 6s ease-in-out infinite;
    }

    .hero-bg-right {
        position: absolute;
        right: -10px;
        top: 50%;
        transform: translateY(-50%);
        width: 130px;
        opacity: 0.4;
        z-index: 1;
        filter: blur(3px);
        pointer-events: none;
        animation: floatRight 7s ease-in-out infinite;
    }

    @keyframes floatLeft {
        0%, 100% { transform: translateY(-50%) rotate(-3deg); }
        50% { transform: translateY(-55%) rotate(-5deg); }
    }

    @keyframes floatRight {
        0%, 100% { transform: translateY(-50%) rotate(3deg); }
        50% { transform: translateY(-45%) rotate(5deg); }
    }

    /* Breakpoints para las imágenes (los originales) */
    @media (min-width: 576px) {
        .hero-main { max-width: 380px; }
        .hero-bg-left { width: 160px; left: -20px; }
        .hero-bg-right { width: 150px; right: -20px; }
        .hero-visual { min-height: 45vh; }
    }
    @media (min-width: 768px) {
        .hero-main { max-width: 420px; }
        .hero-bg-left { width: 200px; left: -30px; opacity: 0.35; }
        .hero-bg-right { width: 180px; right: -30px; opacity: 0.35; }
        .hero-visual { min-height: 50vh; }
    }
    @media (min-width: 992px) {
        .hero-main { max-width: 480px; }
        .hero-bg-left { width: 250px; left: -40px; opacity: 0.35; filter: blur(3px); }
        .hero-bg-right { width: 230px; right: -40px; opacity: 0.35; filter: blur(3px); }
        .hero-visual { min-height: 55vh; }
    }
    @media (min-width: 1200px) {
        .hero-main { max-width: 550px; }
        .hero-bg-left { width: 300px; left: -60px; opacity: 0.3; filter: blur(4px); }
        .hero-bg-right { width: 280px; right: -60px; opacity: 0.3; filter: blur(4px); }
        .hero-visual { min-height: 65vh; }
    }
    @media (max-width: 575px) {
        .hero-main { max-width: 260px; }
        .hero-bg-left { width: 100px; left: -5px; opacity: 0.3; filter: blur(2px); }
        .hero-bg-right { width: 90px; right: -5px; opacity: 0.3; filter: blur(2px); }
        .hero-visual { min-height: 35vh; }
    }
        /* ============================================ */
    /* ESTILOS DEL TEXTO Y BOTONES DEL HERO         */
    /* ============================================ */
    .hero-title {
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 800;
        line-height: 1.1;
        letter-spacing: -2px;
        color: var(--text-main);
        margin-bottom: 1.5rem;
    }

    .hero-subtitle {
        font-size: clamp(1rem, 2vw, 1.25rem);
        color: var(--text-muted);
        max-width: 500px;
        margin-bottom: 2.5rem;
        /* En móvil centramos el subtítulo */
        margin-left: auto;
        margin-right: auto;
    }

    @media (min-width: 992px) {
        .hero-subtitle {
            margin-left: 0;
            margin-right: 0;
        }
    }

    /* Botones */
    .btn-custom {
        display: inline-flex;
        align-items: center;
        padding: 0.8rem 1.8rem;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-custom-primary {
        background: var(--primary);
        color: white;
    }

    .btn-custom-primary:hover {
        background: #4f46e5;
        color: white;
    }

    .btn-custom-outline {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-main);
    }

    .btn-custom-outline:hover {
        background: var(--bg-hover);
        border-color: var(--text-muted);
        color: white;
    }

    /* ============================================ */
    /* BENTO GRID (Para las características)        */
    /* ============================================ */
    .bento-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 1px;
        background: var(--border-color);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        overflow: hidden;
    }

    .bento-item {
        background: var(--bg-surface);
        padding: 2.5rem 2rem;
        transition: background 0.2s;
    }

    .bento-item:hover {
        background: var(--bg-hover);
    }

    .bento-icon {
        font-size: 1.5rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
    }

    .bento-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }

    .bento-text {
        font-size: 0.9rem;
        color: var(--text-muted);
        line-height: 1.6;
        margin: 0;
    }

    @media (min-width: 768px) {
        .bento-grid { grid-template-columns: repeat(3, 1fr); }
    }

    /* ============================================ */
    /* STATS SECTION (Sin cajas)                    */
    /* ============================================ */
    .stats-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        padding: 4rem 0;
        border-top: 1px solid var(--border-color);
        border-bottom: 1px solid var(--border-color);
    }

    .stat-item {
        flex: 1;
        min-width: 150px;
        text-align: center;
        border-right: 1px solid var(--border-color);
    }

    .stat-item:last-child {
        border-right: none;
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1;
    }

    .stat-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--text-muted);
        margin-top: 0.5rem;
    }

    @media (max-width: 767px) {
        .stat-item {
            border-right: none;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .stat-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
    }

    /* ============================================ */
    /* BOTONES Y CTA                                */
    /* ============================================ */
    .btn-custom {
        display: inline-flex;
        align-items: center;
        padding: 0.8rem 1.8rem;
        font-weight: 600;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .btn-custom-primary {
        background: var(--primary);
        color: white;
    }

    .btn-custom-primary:hover {
        background: #4f46e5;
        color: white;
    }

    .btn-custom-outline {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-main);
    }

    .btn-custom-outline:hover {
        background: var(--bg-hover);
        border-color: var(--text-muted);
        color: white;
    }

    .cta-container {
        padding: 5rem 2rem;
        text-align: center;
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        margin: 4rem 0;
    }

    /* Animación sutil */
    .fade-up {
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.6s ease-out, transform 0.6s ease-out;
    }
    .fade-up.visible {
        opacity: 1;
        transform: translateY(0);
    }
</style>

<!-- HERO SECTION -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center g-4">
            <!-- Columna izquierda: texto -->
            <div class="col-lg-6 text-center text-lg-start">
                <h1 class="hero-title">
                    Componentes para tu <br>
                    <span style="color: var(--primary);">máximo</span> rendimiento.
                </h1>
                <p class="hero-subtitle">
                    En HardStore MS encuentras el hardware definitivo. Sin rodeos, solo potencia para tu setup. Armamos tu PC ideal con asesoría real y garantía oficial.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ route('productos.index') }}" class="btn-custom btn-custom-primary">
                        Explorar Catálogo <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                    <a href="#footer-sucursales" class="btn-custom btn-custom-outline">
                        Nuestras Sucursales
                    </a>
                </div>
            </div>
            <!-- Columna derecha: imágenes (las 3 juntas) -->
            <div class="col-lg-6 mt-3 mt-lg-0">
                <div class="hero-visual">
                    <img src="{{ asset('imagenes/principal/Ramcito.png') }}" class="hero-bg-left" alt="RAM">
                    <img src="{{ asset('imagenes/principal/RTX3090.png') }}" class="hero-bg-right" alt="GPU">
                    <img src="{{ asset('imagenes/principal/PCerda.png') }}" class="hero-main" alt="PC">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CARACTERÍSTICAS (Bento Grid) -->
<section class="container py-5 my-4">
    <div class="mb-5">
        <h2 class="fw-bold mb-2" style="color: var(--text-main); font-size: 2rem;">Por qué elegirnos</h2>
        <p style="color: var(--text-muted);">No somos solo una tienda, somos tu equipo técnico.</p>
    </div>
    
    <div class="bento-grid fade-up">
        <div class="bento-item">
            <i class="bi bi-cpu bento-icon"></i>
            <h3 class="bento-title">Última Tecnología</h3>
            <p class="bento-text">RTX 40 Series, procesadores Ryzen 7000 y memorias DDR5. Stock actualizado cada semana para entusiastas.</p>
        </div>
        <div class="bento-item">
            <i class="bi bi-person-check bento-icon"></i>
            <h3 class="bento-title">Asesoría Real</h3>
            <p class="bento-text">No te vendemos por vender. Te ayudamos a elegir los componentes exactos que necesitas según tu presupuesto.</p>
        </div>
        <div class="bento-item">
            <i class="bi bi-shield-check bento-icon"></i>
            <h3 class="bento-title">Garantía Oficial</h3>
            <p class="bento-text">Todos nuestros productos cuentan con garantía directa del fabricante. Tu inversión está segura.</p>
        </div>
    </div>
</section>

<!-- COMBOS (Si hay datos) -->
@if(isset($combos) && count($combos) > 0)
<section class="container py-5 my-4">
    <div class="mb-5">
        <h2 class="fw-bold mb-2" style="color: var(--text-main); font-size: 2rem;">Combos Recomendados</h2>
        <p style="color: var(--text-muted);">Componentes que ya sabemos que funcionan juntos.</p>
    </div>

    <div class="row g-4">
        @foreach($combos as $index => $combo)
            <div class="col-md-6 col-lg-4 fade-up">
                <div class="p-4" style="background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: 1rem;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge" style="background: rgba(99, 102, 241, 0.1); color: var(--primary);">Combo {{ $index + 1 }}</span>
                    </div>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2 d-flex align-items-center gap-2" style="color: var(--text-main); font-size: 0.9rem;">
                            <i class="bi bi-cpu" style="color: var(--primary);"></i> {{ $combo['cpu']->name }}
                        </li>
                        <li class="mb-2 d-flex align-items-center gap-2" style="color: var(--text-main); font-size: 0.9rem;">
                            <i class="bi bi-motherboard" style="color: var(--primary);"></i> {{ $combo['placa']->name }}
                        </li>
                        <li class="d-flex align-items-center gap-2" style="color: var(--text-main); font-size: 0.9rem;">
                            <i class="bi bi-memory" style="color: var(--primary);"></i> {{ $combo['ram']->name }}
                        </li>
                    </ul>
                    <div class="d-flex justify-content-between align-items-center border-top pt-3" style="border-color: var(--border-color) !important;">
                        <span class="fw-bold" style="color: var(--text-main); font-size: 1.1rem;">
                            ${{ number_format($combo['cpu']->precio_venta + $combo['placa']->precio_venta + $combo['ram']->precio_venta, 0, ',', '.') }}
                        </span>
                        <a href="{{ route('productos.index', ['combo' => $combo['cpu']->id]) }}" class="btn-custom btn-custom-outline py-1 px-3" style="font-size: 0.8rem;">
                            Ver
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>
@endif

<!-- ESTADÍSTICAS (Sin cajas) -->
<section class="container">
    <div class="stats-container fade-up">
        <div class="stat-item">
            <div class="stat-value">5k+</div>
            <div class="stat-label">Clientes Felices</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">1200+</div>
            <div class="stat-label">Equipos Armados</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">4.9★</div>
            <div class="stat-label">Calificación Promedio</div>
        </div>
        <div class="stat-item">
            <div class="stat-value">24/7</div>
            <div class="stat-label">Soporte Online</div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="container">
    <div class="cta-container fade-up">
        <h2 class="fw-bold mb-3" style="color: var(--text-main); font-size: 2.2rem;">¿Listo para armar tu PC ideal?</h2>
        <p class="mb-4" style="color: var(--text-muted); font-size: 1.1rem;">Regístrate y accede a ofertas exclusivas, envíos prioritarios y nuestro asistente virtual.</p>
        @guest
            <a href="{{ route('register') }}" class="btn-custom btn-custom-primary">Crear cuenta gratis</a>
        @else
            <a href="{{ route('productos.index') }}" class="btn-custom btn-custom-primary">Explorar productos</a>
        @endguest
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fadeElements = document.querySelectorAll('.fade-up');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) entry.target.classList.add('visible');
            });
        }, { threshold: 0.15 });
        fadeElements.forEach(el => observer.observe(el));
    });
</script>
@endsection