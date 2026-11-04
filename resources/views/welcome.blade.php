@extends('layouts.app')

@section('content')
<style>
    /* ============================================ */
    /* HERO SECTION CON UNIDADES RELATIVAS          */
    /* ============================================ */
    .hero-visual {
        position: relative;
        min-height: 40vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Imagen principal (PCerda) - más grande en desktop */
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

    /* Imágenes acompañantes - más grandes en desktop */
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

    /* ============================================ */
    /* BREAKPOINTS PROGRESIVOS                      */
    /* ============================================ */
    
    /* Tablet pequeña */
    @media (min-width: 576px) {
        .hero-main { max-width: 380px; }
        .hero-bg-left { width: 160px; left: -20px; }
        .hero-bg-right { width: 150px; right: -20px; }
        .hero-visual { min-height: 45vh; }
    }

    /* Tablet grande */
    @media (min-width: 768px) {
        .hero-main { max-width: 420px; }
        .hero-bg-left { width: 200px; left: -30px; opacity: 0.35; }
        .hero-bg-right { width: 180px; right: -30px; opacity: 0.35; }
        .hero-visual { min-height: 50vh; }
    }

    /* Desktop pequeño */
    @media (min-width: 992px) {
        .hero-main { max-width: 480px; }
        .hero-bg-left { width: 250px; left: -40px; opacity: 0.35; filter: blur(3px); }
        .hero-bg-right { width: 230px; right: -40px; opacity: 0.35; filter: blur(3px); }
        .hero-visual { min-height: 55vh; }
    }

    /* Desktop grande */
    @media (min-width: 1200px) {
        .hero-main { max-width: 550px; }
        .hero-bg-left { width: 300px; left: -60px; opacity: 0.3; filter: blur(4px); }
        .hero-bg-right { width: 280px; right: -60px; opacity: 0.3; filter: blur(4px); }
        .hero-visual { min-height: 65vh; }
    }

    /* Móvil */
    @media (max-width: 575px) {
        .hero-main { max-width: 260px; }
        .hero-bg-left { width: 100px; left: -5px; opacity: 0.3; filter: blur(2px); }
        .hero-bg-right { width: 90px; right: -5px; opacity: 0.3; filter: blur(2px); }
        .hero-visual { min-height: 35vh; }
    }

    .feature-card {
        background: var(--bg-surface); /* Color sólido */
        border: 1px solid var(--border-color); /* Borde sutil */
        border-radius: 1rem; /* Bordes un poco menos redondos */
        padding: 1.5rem;
        transition: border-color 0.3s ease, transform 0.3s ease;
        height: 100%;
    }

    .feature-card:hover {
        border-color: var(--primary);
        transform: translateY(-4px);
        /* Eliminamos el cambio de fondo y el blur */
    }

    .feature-icon {
        font-size: 2rem;
        color: var(--primary); /* Icono sólido, sin gradiente */
        margin-bottom: 1rem;
    }

    @media (min-width: 768px) {
        .feature-card { padding: 1.5rem; }
        .feature-icon { font-size: 2.5rem; }
    }

    @media (min-width: 1200px) {
        .feature-card { padding: 1.8rem; }
        .feature-icon { font-size: 2.8rem; }
    }

    .stat-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        padding: 1.5rem;
        text-align: center;
        transition: border-color 0.2s;
    }

    .stat-card:hover {
        border-color: var(--primary);
    }

    .stat-number {
        font-size: 1.8rem;
        font-weight: 800;
        color: var(--text-main);
    }

    @media (min-width: 768px) {
        .stat-card { padding: 1.2rem; }
        .stat-number { font-size: 1.8rem; }
    }

    @media (min-width: 1200px) {
        .stat-card { padding: 1.5rem; }
        .stat-number { font-size: 2rem; }
    }

    .cta-section {
        background: var(--bg-surface); 
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        padding: 3rem 2rem;
        text-align: center;
    }

    @media (min-width: 768px) {
        .cta-section { padding: 2rem; border-radius: 1.75rem; }
    }

    @media (min-width: 1200px) {
        .cta-section { padding: 3rem; border-radius: 2rem; }
    }

       .btn-cta {
        background: var(--primary);
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 8px; 
        font-weight: 600;
        font-size: 1rem;
        color: white;
        transition: background 0.2s;
        display: inline-block;
    }

    .btn-cta:hover {
        background: #0077cc;
        color: white;
    }

    @media (min-width: 768px) {
        .btn-cta { padding: 0.7rem 1.8rem; font-size: 1rem; }
    }

    @media (min-width: 1200px) {
        .btn-cta { padding: 0.8rem 2rem; font-size: 1.1rem; }
    }

    /* ============================================ */
    /* TEXTOS RESPONSIVOS                           */
    /* ============================================ */
    .display-4 {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .display-6 {
        font-size: 1.4rem;
        font-weight: 700;
    }

    .lead {
        font-size: 0.95rem;
        line-height: 1.5;
    }

    @media (min-width: 768px) {
        .display-4 { font-size: 2.2rem; }
        .display-6 { font-size: 1.8rem; }
        .lead { font-size: 1rem; }
    }

    @media (min-width: 992px) {
        .display-4 { font-size: 2.5rem; }
        .display-6 { font-size: 2rem; }
        .lead { font-size: 1.1rem; }
    }

    @media (min-width: 1200px) {
        .display-4 { font-size: 3rem; }
        .lead { font-size: 1.2rem; }
    }

    /* ============================================ */
    /* ANIMACIONES                                  */
    /* ============================================ */
    .fade-up {
        opacity: 0;
        transform: translateY(2rem);
        transition: all 0.6s ease-out;
    }

    .fade-up.visible {
        opacity: 1;
        transform: translateY(0);
    }

    /* Botones responsivos */
    .btn-primary.btn-lg, .btn-outline.btn-lg {
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
    }

    @media (min-width: 768px) {
        .btn-primary.btn-lg, .btn-outline.btn-lg {
            padding: 0.6rem 1.5rem;
            font-size: 0.95rem;
        }
    }

    @media (min-width: 992px) {
        .btn-primary.btn-lg, .btn-outline.btn-lg {
            padding: 0.7rem 1.8rem;
            font-size: 1rem;
        }
    }
    .btn-outline-pixelfed {
    background: transparent;
    border: 1px solid rgba(0, 149, 246, 0.5);
    color: #0095f6;
    border-radius: 40px;
    padding: 0.3rem 0.8rem;
    font-size: 0.7rem;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-outline-pixelfed:hover {
    background: #0095f6;
    color: white;
}
</style>

<!-- Hero Section -->
<section class="container py-3 py-md-5 my-2 my-md-4">
    <div class="row align-items-center g-4">
        <!-- Columna izquierda: texto -->
        <div class="col-lg-6 text-center text-lg-start order-2 order-lg-1 animate__animated animate__fadeInLeft">
            <h1 class="display-4 fw-bold mb-3 mb-md-4">
                Potencia tu <span style="color: #0095f6;">Setup</span>
            </h1>
            <p class="lead mb-3 mb-md-4 text-secondary">
                En <strong class="text-white">HardStore MS</strong> encuentras los componentes más potentes del mercado. 
                GPU, CPU, RAM y más para llevar tu PC al siguiente nivel.
            </p>
            <div class="d-flex flex-column flex-sm-row gap-3 mb-4 justify-content-center justify-content-lg-start">
                <a href="{{ route('productos.index') }}" class="btn btn-primary btn-lg px-4">
                    Ver Catálogo <i class="bi bi-arrow-right ms-2"></i>
                </a>
                <a href="#footer-sucursales" class="btn btn-outline btn-lg px-4">
                    <i class="bi bi-geo-alt me-2"></i>Ver Sucursales
                </a>
            </div>

            <!-- Badges -->
            <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                <div class="d-flex align-items-center">
                    <i class="bi bi-truck fs-5 text-primary me-2"></i> 
                    <span class="small fw-semibold">Envíos a toda Bolivia</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-shield-check fs-5 text-primary me-2"></i> 
                    <span class="small fw-semibold">Garantía oficial</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-credit-card fs-5 text-primary me-2"></i> 
                    <span class="small fw-semibold">Hasta 12 cuotas</span>
                </div>
            </div>
        </div>

        <!-- Columna derecha: imágenes flotantes -->
        <div class="col-lg-6 mt-3 mt-lg-0 order-1 order-lg-2">
            <div class="hero-visual">
                <img src="{{ asset('imagenes/principal/Ramcito.png') }}" 
                     class="hero-bg-left" 
                     alt="Memoria RAM">
                <img src="{{ asset('imagenes/principal/RTX3090.png') }}" 
                     class="hero-bg-right" 
                     alt="RTX 3090">
                <img src="{{ asset('imagenes/principal/PCerda.png') }}" 
                     class="hero-main animate__animated animate__zoomIn" 
                     alt="PC Gaming">
            </div>
        </div>
    </div>
</section>

<!-- Sección de características -->
<section class="container py-3 py-md-5 my-2 my-md-3" id="features">
    <div class="text-center mb-4 mb-md-5">
        <h2 class="display-6 fw-bold">¿Por qué elegirnos?</h2>
        <p class="text-secondary">Experiencia, calidad y confianza en cada componente</p>
    </div>

    <div class="row g-3 g-md-4">
        <div class="col-md-4 fade-up">
            <div class="feature-card text-center">
                <i class="bi bi-cpu feature-icon"></i>
                <h4 class="text-white mt-2 mt-md-3">Última Tecnología</h4>
                <p class="text-secondary small">RTX 40 Series, Ryzen 7000, DDR5. Stock actualizado semanalmente.</p>
            </div>
        </div>
        <div class="col-md-4 fade-up">
            <div class="feature-card text-center">
                <i class="bi bi-person-check feature-icon"></i>
                <h4 class="text-white mt-2 mt-md-3">Asesoría Experta</h4>
                <p class="text-secondary small">Te guiamos para armar el PC perfecto según tu presupuesto.</p>
            </div>
        </div>
        <div class="col-md-4 fade-up">
            <div class="feature-card text-center">
                <i class="bi bi-graph-up feature-icon"></i>
                <h4 class="text-white mt-2 mt-md-3">Precios Competitivos</h4>
                <p class="text-secondary small">El mejor equilibrio entre calidad y precio del mercado.</p>
            </div>
        </div>
    </div>
</section>
<!-- ============================================ -->
<!-- SECCIÓN DE COMBOS RECOMENDADOS               -->
<!-- ============================================ -->
<section class="container py-3 py-md-5 my-2 my-md-3" id="combos">
    <div class="text-center mb-4 mb-md-5">
        <h2 class="display-6 fw-bold">🔥 Combos Recomendados</h2>
        <p class="text-secondary">Equipos compatibles listos para armar tu PC</p>
    </div>

    @if(isset($combos) && count($combos) > 0)
        <div class="row g-3 g-md-4">
            @foreach($combos as $index => $combo)
                <div class="col-md-4 col-lg-3 fade-up">
                    <div class="feature-card text-center p-3 p-md-4" style="border-color: rgba(40, 167, 69, 0.3);">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-primary bg-opacity-25 text-primary">Combo {{ $index + 1 }}</span>
                            <span class="badge bg-success bg-opacity-25 text-success">
                                <i class="bi bi-check-circle"></i> Disponible
                            </span>
                        </div>
                        <div class="text-start">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-cpu text-primary"></i>
                                <strong class="text-white small">{{ $combo['cpu']->name }}</strong>
                            </div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi bi-motherboard text-primary"></i>
                                <span class="text-secondary small">{{ $combo['placa']->name }}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-memory text-primary"></i>
                                <span class="text-secondary small">{{ $combo['ram']->name }}</span>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <span class="fw-bold" style="color: #0095f6;">
                                ${{ number_format($combo['cpu']->precio_venta + $combo['placa']->precio_venta + $combo['ram']->precio_venta, 0, ',', '.') }}
                            </span>
                            @if(isset($combo['cpu']->id) && $combo['cpu']->id > 0)
                                <a href="{{ route('productos.index', ['combo' => $combo['cpu']->id]) }}" class="btn btn-sm btn-outline-pixelfed">
                                    Ver combo completo
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-4">
            <i class="bi bi-boxes fs-1 text-muted"></i>
            <p class="text-muted mt-2">No hay combos disponibles en este momento.</p>
        </div>
    @endif
</section>

<!-- Estadísticas -->
<section class="container py-3 py-md-4">
    <div class="row g-3 g-md-4">
        <div class="col-6 col-md-3 fade-up">
            <div class="stat-card">
                <div class="stat-number">5k+</div>
                <div class="small text-secondary">Clientes felices</div>
            </div>
        </div>
        <div class="col-6 col-md-3 fade-up">
            <div class="stat-card">
                <div class="stat-number">1200+</div>
                <div class="small text-secondary">Productos vendidos</div>
            </div>
        </div>
        <div class="col-6 col-md-3 fade-up">
            <div class="stat-card">
                <div class="stat-number">4.9★</div>
                <div class="small text-secondary">Calificación</div>
            </div>
        </div>
        <div class="col-6 col-md-3 fade-up">
            <div class="stat-card">
                <div class="stat-number">24/7</div>
                <div class="small text-secondary">Soporte online</div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="container my-4 my-md-5">
    <div class="cta-section fade-up">
        <h3 class="fw-bold mb-2 mb-md-3">¿Listo para armar tu PC ideal?</h3>
        <p class="text-secondary mb-3 mb-md-4">Regístrate y accede a ofertas exclusivas + envíos prioritarios</p>
        @guest
            <a href="{{ route('register') }}" class="btn-cta">Crear cuenta gratis <i class="bi bi-arrow-right ms-2"></i></a>
        @else
            <a href="{{ route('productos.index') }}" class="btn-cta">Explorar productos <i class="bi bi-arrow-right ms-2"></i></a>
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