{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>HardStore MS | Tienda de Hardware</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <style>
    :root {
        /* Nueva paleta profesional 2026 (Dark-First Neutral) */
        --bg-base: #09090b;       /* Fondo principal casi negro */
        --bg-surface: #121215;    /* Fondo de tarjetas y navbar */
        --bg-hover: #18181b;      /* Hover de tarjetas */
        --border-color: #27272a;  /* Bordes sutiles */
        
        --text-main: #f4f4f5;     /* Blanco suave */
        --text-muted: #a1a1aa;    /* Gris para textos secundarios */
        --primary: #0095f6;       /* Azul principal (solo para acentos) */
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body { 
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background-color: var(--bg-base);
        color: var(--text-main);
        min-height: 100vh;
        overflow-x: hidden;
        font-size: 16px;
        line-height: 1.5;
        /* Eliminamos el gradiente radial y el grid de fondo para limpiar la vista */
    }

    /* ============================================ */
    /* NAVBAR MINIMALISTA                           */
    /* ============================================ */
    .navbar {
        background-color: var(--bg-surface) !important;
        border-bottom: 1px solid var(--border-color);
        padding: 0.75rem 0;
        transition: all 0.3s ease;
    }

    .navbar-brand {
        font-weight: 800;
        letter-spacing: -0.5px;
        font-size: clamp(1.1rem, 5vw, 1.4rem);
        color: white !important;
    }

    .brand-icon {
        background: var(--primary);
        width: 2rem;
        height: 2rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        color: white;
        font-weight: 800;
        margin-right: 0.5rem;
        font-size: 1rem;
    }

    .nav-link {
        color: var(--text-muted) !important;
        font-weight: 500;
        font-size: 0.9rem;
        padding: 0.5rem 1rem !important;
        transition: color 0.2s;
    }

    .nav-link:hover, .nav-link.active {
        color: var(--text-main) !important;
    }

    /* Buscador */
    .search-container input {
        background: var(--bg-base) !important;
        border: 1px solid var(--border-color) !important;
        border-radius: 8px !important;
        padding: 0.5rem 0.9rem 0.5rem 2.4rem !important;
        color: white !important;
        font-size: 0.85rem;
        transition: border-color 0.3s;
        width: 100%;
    }

    .search-container input:focus {
        border-color: var(--primary) !important;
        outline: none;
    }

    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    /* Botones */
    .btn-primary {
        background: var(--primary);
        border: none;
        border-radius: 8px;
        padding: 0.5rem 1.2rem;
        font-weight: 600;
        font-size: 0.85rem;
        color: white;
        transition: background 0.2s;
    }

    .btn-primary:hover {
        background: #0077cc;
        color: white;
    }

    .btn-outline {
        background: transparent;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.5rem 1.2rem;
        color: var(--text-main);
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-outline:hover {
        border-color: var(--text-muted);
        background: var(--bg-hover);
        color: white;
    }

    /* ============================================ */
    /* FOOTER MINIMALISTA                           */
    /* ============================================ */
    footer {
        background-color: var(--bg-surface);
        border-top: 1px solid var(--border-color);
        padding: 3rem 0 2rem;
        margin-top: 4rem;
    }

    .footer-title {
        color: var(--text-main);
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
        margin-bottom: 1.2rem;
    }

    .footer-link {
        color: var(--text-muted);
        text-decoration: none;
        font-size: 0.85rem;
        display: block;
        margin-bottom: 0.6rem;
        transition: color 0.2s;
    }
    
    .footer-link:hover {
        color: var(--primary);
    }

    /* ============================================ */
    /* MEDIA QUERIES RESPONSIVAS                    */
    /* ============================================ */
    @media (max-width: 991px) {
        .navbar-collapse {
            background: var(--bg-surface);
            border-radius: 8px;
            margin-top: 1rem;
            padding: 1rem;
            border: 1px solid var(--border-color);
        }
        
        .search-container { max-width: 100%; margin-bottom: 0.5rem; }
        .navbar-nav { margin: 1rem 0; }
        .nav-link { text-align: center; padding: 0.75rem !important; }
        
        .dropdown-menu {
            width: 100%;
            position: static !important;
            transform: none !important;
            margin-top: 0.5rem !important;
            background-color: var(--bg-base) !important;
            border: 1px solid var(--border-color) !important;
        }
        
        .btn-primary, .btn-outline { width: 100%; text-align: center; margin: 0.25rem 0; }
        .d-flex.align-items-lg-center { flex-direction: column; width: 100%; }
    }

    @media (max-width: 576px) {
        .navbar-brand { font-size: 1rem; }
        footer .row > div { text-align: center; }
        .footer-title { text-align: center; }
        footer .d-flex { justify-content: center; }
    }
</style>
</head>
<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/">
                <div class="brand-icon">H</div>
                HardStore<span style="color: #0095f6;">MS</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2 text-white"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="mx-auto search-container position-relative">
                    <form action="{{ route('productos.index') }}" method="GET" class="w-100">
                        <i class="bi bi-search search-icon"></i>
                        <input class="form-control" type="search" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar hardware...">
                    </form>
                </div>

                <ul class="navbar-nav align-items-lg-center gap-1 w-100 w-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('productos*') ? 'active' : '' }}" href="/productos">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#footer-sucursales">Contacto</a>
                    </li>
                </ul>
                
                <!-- Botones de autenticación responsivos -->
                <div class="d-flex flex-column flex-lg-row align-items-center gap-2 ms-lg-3 w-100 w-lg-auto">
                    @auth
                        <div class="dropdown w-100 w-lg-auto">
                            <button class="btn btn-outline dropdown-toggle d-flex align-items-center justify-content-center gap-2 w-100" 
                                    type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end w-100">
    @if(auth()->user()->rol === 'cliente')
        <li><a class="dropdown-item" href="{{ route('cliente.panel') }}"><i class="bi bi-person-circle me-2"></i>Mi Panel</a></li>
    @else
        <li><a class="dropdown-item" href="{{ route('perfil.vendedor') }}"><i class="bi bi-person-circle me-2"></i>Mi Perfil</a></li>
    @endif
    <li><hr class="dropdown-divider"></li>
    @if(auth()->user()->rol === 'admin')
        <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a></li>
        <li><a class="dropdown-item" href="{{ route('productos.stock') }}"><i class="bi bi-box-seam me-2"></i>Inventario</a></li>
        <li><a class="dropdown-item" href="{{ route('productos.create') }}"><i class="bi bi-plus-square me-2"></i>Publicar</a></li>
        <li><hr class="dropdown-divider"></li>
    @endif
    <li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i>Salir</button>
        </form>
    </li>
</ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline w-100 w-lg-auto">Entrar</a>
                        <a href="{{ route('register') }}" class="btn btn-primary w-100 w-lg-auto">Registrarse</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer id="footer-sucursales">
        <div class="container">
            <div class="row g-4">
                <div class="col-12 col-lg-4 text-center text-lg-start">
                    <div class="d-flex align-items-center justify-content-center justify-content-lg-start mb-3">
                        <div class="brand-icon" style="width: 2.5rem; height: 2.5rem;">H</div>
                        <span class="fw-bold fs-4">HardStore<span style="color: #0095f6;">MS</span></span>
                    </div>
                    <p class="text-secondary small">Líderes en hardware de alto rendimiento. Más de 5,000 clientes confían en nosotros.</p>
                    <div class="mt-3 d-flex justify-content-center justify-content-lg-start gap-3">
                        <a href="#" class="text-secondary"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="text-secondary"><i class="bi bi-facebook fs-5"></i></a>
                        <a href="#" class="text-secondary"><i class="bi bi-twitter-x fs-5"></i></a>
                    </div>
                </div>

                <div class="col-12 col-lg-8">
                    <h6 class="footer-title text-center text-lg-start">📍 NUESTRAS SUCURSALES</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex flex-column flex-sm-row mb-3 text-center text-sm-start">
                                <i class="bi bi-building fs-5 text-primary me-sm-3 mb-2 mb-sm-0"></i>
                                <div>
                                    <strong class="text-white">Sede Central</strong>
                                    <p class="text-secondary small mb-0">Parque Industrial, Calle 1 #234</p>
                                    <p class="text-secondary small">📞 +56 2 1234 5678</p>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-sm-row mb-3 text-center text-sm-start">
                                <i class="bi bi-shop fs-5 text-primary me-sm-3 mb-2 mb-sm-0"></i>
                                <div>
                                    <strong class="text-white">Branch Norte</strong>
                                    <p class="text-secondary small mb-0">Centro Comercial Plaza Norte, Local 45</p>
                                    <p class="text-secondary small">📞 +56 2 2345 6789</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-column flex-sm-row mb-3 text-center text-sm-start">
                                <i class="bi bi-geo-alt fs-5 text-primary me-sm-3 mb-2 mb-sm-0"></i>
                                <div>
                                    <strong class="text-white">Branch Sur</strong>
                                    <p class="text-secondary small mb-0">Avenida Principal #1560</p>
                                    <p class="text-secondary small">📞 +56 2 3456 7890</p>
                                </div>
                            </div>
                            <div class="d-flex flex-column flex-sm-row mb-3 text-center text-sm-start">
                                <i class="bi bi-truck fs-5 text-primary me-sm-3 mb-2 mb-sm-0"></i>
                                <div>
                                    <strong class="text-white">Punto de Venta Express</strong>
                                    <p class="text-secondary small mb-0">Terminal de Buses, Local 12</p>
                                    <p class="text-secondary small">📞 +56 2 4567 8901</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-4 mt-4 border-top border-secondary border-opacity-25 text-center">
                <p class="text-secondary small mb-0">&copy; {{ date('Y') }} HardStore MS. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Scroll suave para el enlace de contacto
        document.querySelector('a[href="#footer-sucursales"]')?.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector('#footer-sucursales').scrollIntoView({ behavior: 'smooth' });
        });
        
        // Cerrar menú al hacer clic en un enlace (móvil)
        document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
            link.addEventListener('click', () => {
                const navbarCollapse = document.querySelector('.navbar-collapse');
                if (navbarCollapse.classList.contains('show')) {
                    navbarCollapse.classList.remove('show');
                }
            });
        });
    </script>
    @include('partials.asistente')
</body>
</html>