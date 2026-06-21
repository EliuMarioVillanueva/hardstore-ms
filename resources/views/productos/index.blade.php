{{-- resources/views/productos/index.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    /* ============================================ */
    /* ESTILOS BASE RESPONSIVOS                     */
    /* ============================================ */
    
    /* Sidebar de categorías - en móvil se oculta o va abajo */
    .sidebar-categories {
        background: rgba(15, 25, 45, 0.5);
        backdrop-filter: blur(10px);
        border-radius: 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.08);
        padding: 1rem 0;
        margin-bottom: 1.5rem;
    }

    .sidebar-categories .nav-link {
        color: #a0a0b0;
        padding: 0.6rem 1.2rem;
        transition: all 0.2s ease;
        border-left: 3px solid transparent;
        font-size: 0.9rem;
    }

    .sidebar-categories .nav-link:hover {
        color: white;
        background: rgba(0, 149, 246, 0.1);
        border-left-color: #0095f6;
    }

    .sidebar-categories .nav-link.active {
        color: #0095f6;
        background: rgba(0, 149, 246, 0.15);
        border-left-color: #0095f6;
    }

    /* Tarjeta de producto */
    .product-card {
        background: rgba(15, 25, 45, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.25rem;
        transition: all 0.3s ease;
        overflow: hidden;
        height: 100%;
    }

    .product-card:hover {
        transform: translateY(-0.3rem);
        border-color: #0095f6;
        box-shadow: 0 0.75rem 1.75rem rgba(0, 0, 0, 0.3);
    }

    .product-image {
        background: linear-gradient(135deg, rgba(0, 149, 246, 0.1), rgba(0, 195, 255, 0.05));
        height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        padding: 0.8rem;
        transition: transform 0.2s;
    }

    .product-card:hover .product-image img {
        transform: scale(1.03);
    }

    .badge-category {
        background: rgba(0, 149, 246, 0.15);
        color: #0095f6;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.25rem 0.75rem;
        border-radius: 2rem;
    }

    .product-sku {
        font-family: 'Monaco', 'Courier New', monospace;
        font-size: 0.65rem;
        color: #6c757d;
    }

    .btn-outline-pixelfed {
        border: 1px solid rgba(0, 149, 246, 0.5);
        background: transparent;
        color: #0095f6;
        border-radius: 2.5rem;
        padding: 0.4rem 1rem;
        font-size: 0.8rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-outline-pixelfed:hover {
        background: #0095f6;
        color: white;
        transform: translateY(-1px);
    }

    .btn-primary-pixelfed {
        background: linear-gradient(135deg, #0095f6, #00c3ff);
        border: none;
        border-radius: 2.5rem;
        padding: 0.5rem 1.2rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-primary-pixelfed:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 0.75rem rgba(0, 149, 246, 0.4);
    }

    /* Header del catálogo */
    .catalog-header {
        background: linear-gradient(135deg, rgba(0, 149, 246, 0.1), rgba(0, 195, 255, 0.05));
        border-radius: 1.5rem;
        padding: 1rem 1.2rem;
        margin-bottom: 1.5rem;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }

    /* ============================================ */
    /* BOTÓN DE FILTRO PARA MÓVIL                   */
    /* ============================================ */
    .btn-filter-mobile {
        display: none;
        background: rgba(0, 149, 246, 0.15);
        border: 1px solid rgba(0, 149, 246, 0.3);
        color: #0095f6;
        border-radius: 2rem;
        padding: 0.5rem 1rem;
        font-size: 0.85rem;
        margin-bottom: 1rem;
        width: 100%;
    }

    .btn-filter-mobile i {
        margin-right: 0.5rem;
    }

    /* ============================================ */
    /* MEDIA QUERIES RESPONSIVAS                    */
    /* ============================================ */
    
    /* Móvil: sidebar oculto por defecto, productos primero */
    @media (max-width: 767px) {
        .btn-filter-mobile {
            display: block;
        }
        
        .sidebar-categories {
            display: none;
            margin-bottom: 1rem;
        }
        
        .sidebar-categories.show {
            display: block;
        }
        
        .catalog-header {
            flex-direction: column;
            text-align: center;
            gap: 0.8rem;
        }
        
        .catalog-header .btn-primary-pixelfed {
            align-self: center;
        }
        
        .product-image {
            height: 140px;
        }
        
        .badge-category {
            font-size: 0.65rem;
        }
        
        .product-sku {
            font-size: 0.6rem;
        }
    }

    /* Tablet */
    @media (min-width: 768px) and (max-width: 991px) {
        .product-image {
            height: 150px;
        }
        
        .badge-category {
            font-size: 0.68rem;
        }
    }

    /* Desktop */
    @media (min-width: 992px) {
        .sidebar-categories {
            display: block !important;
        }
        
        .btn-filter-mobile {
            display: none;
        }
        
        .product-image {
            height: 160px;
        }
        .alert-pixelfed {
    background: rgba(0, 149, 246, 0.1);
    border: 1px solid rgba(0, 149, 246, 0.2);
    border-radius: 16px;
    color: #0095f6;
    padding: 1rem 1.2rem;
}
    }
</style>

<div class="container-fluid py-3 py-md-4">
    <div class="row g-4">
        <!-- SIDEBAR DE CATEGORÍAS (colapsable en móvil) -->
        <div class="col-md-3 col-lg-2">
            <!-- Botón para mostrar/ocultar filtros en móvil -->
            <button class="btn-filter-mobile" id="btnFilterMobile">
                <i class="bi bi-funnel"></i> Filtrar por categoría
            </button>
            
            <div class="sidebar-categories" id="sidebarCategories">
                <h6 class="px-3 mb-3 text-uppercase small text-muted fw-bold">
                    <i class="bi bi-tags me-2"></i>Categorías
                </h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ !$tipoSeleccionado ? 'active' : '' }}" 
                           href="{{ route('productos.index') }}">
                            <i class="bi bi-grid-3x3-gap-fill me-2"></i>Todos
                        </a>
                    </li>
                    @foreach($categorias as $cat)
                        <li class="nav-item">
                            <a class="nav-link {{ $tipoSeleccionado == $cat->tipo ? 'active' : '' }} text-capitalize" 
                               href="{{ route('productos.index', ['tipo' => $cat->tipo]) }}">
                                @switch($cat->tipo)
                                    @case('CPU')<i class="bi bi-cpu me-2"></i>@break
                                    @case('GPU')<i class="bi bi-gpu-card me-2"></i>@break
                                    @case('RAM')<i class="bi bi-memory me-2"></i>@break
                                    @case('Placa')<i class="bi bi-motherboard me-2"></i>@break
                                    @default<i class="bi bi-box me-2"></i>
                                @endswitch
                                {{ $cat->tipo }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <hr class="my-3 mx-3" style="border-color: rgba(255,255,255,0.08);">
                <div class="px-3 text-muted small">
                    <i class="bi bi-info-circle me-1"></i>
                    {{ $productos->count() }} productos disponibles
                </div>
            </div>
        </div>

        <!-- CONTENIDO PRINCIPAL (GRILLA DE PRODUCTOS) -->
        <div class="col-md-9 col-lg-10">
            <!-- Header -->
            <div class="catalog-header d-flex flex-wrap justify-content-between align-items-center">
                <div>
                    <h1 class="h2 fw-bold mb-1" style="color: white;">
                        Catálogo de Hardware
                    </h1>
                    <p class="text-secondary mb-0 small">
                        <i class="bi bi-server me-1"></i>
                        Componentes de alto rendimiento para tu setup
                    </p>
                </div>
                @auth
                    @if(auth()->user()->rol === 'admin')
                        <a href="{{ route('productos.create') }}" class="btn btn-primary-pixelfed">
                            <i class="bi bi-plus-lg me-2"></i>Agregar Producto
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Indicador de combo filtrado -->
@if(request()->has('combo'))
    <div class="alert alert-pixelfed mb-4 d-flex justify-content-between align-items-center">
        <div>
            <i class="bi bi-boxes me-2"></i>
            <strong>Mostrando combo completo</strong> - CPU + Placa Base + RAM compatibles
        </div>
        <a href="{{ route('productos.index') }}" class="btn btn-sm btn-outline-pixelfed">
            <i class="bi bi-x-lg me-1"></i> Limpiar filtro
        </a>
    </div>
@endif

            <!-- Grid de productos -->
            @if($productos->count() > 0)
                <div class="row g-3 g-md-4">
                    @foreach($productos as $producto)
                        <div class="col-6 col-md-4 col-lg-3">
                            <div class="product-card">
                                <div class="product-image">
                                    @php
                                        $imagenUrl = asset('imagenes/productos/default-hardware.png');
                                        
                                        if(str_contains(strtolower($producto->name), 'ryzen')) {
                                            $imagenUrl = asset('imagenes/productos/cpus/amd-ryzen.png');
                                        } elseif(str_contains(strtolower($producto->name), 'core i')) {
                                            $imagenUrl = asset('imagenes/productos/cpus/intel-core.png');
                                        } elseif($producto->tipo == 'Placa' || str_contains(strtolower($producto->name), 'rog') || str_contains(strtolower($producto->name), 'msi')) {
                                            $imagenUrl = asset('imagenes/productos/mothers/motherboard.png');
                                        } elseif($producto->tipo == 'RAM') {
                                            $imagenUrl = asset('imagenes/productos/ram/ram-ddr.png');
                                        } elseif($producto->tipo == 'GPU') {
                                            $imagenUrl = str_contains(strtolower($producto->name), 'rtx') 
                                                ? asset('imagenes/productos/gpus/nvidia-rtx.png')
                                                : asset('imagenes/productos/gpus/amd-radeon.png');
                                        } elseif($producto->tipo == 'SSD') {
                                            $imagenUrl = asset('imagenes/productos/ssd/ssd-m2.png');
                                        } elseif($producto->tipo == 'PSU') {
                                            $imagenUrl = asset('imagenes/productos/psu/psu-corsair.png');
                                        } elseif($producto->tipo == 'Gabinete') {
                                            $imagenUrl = asset('imagenes/productos/cases/gabinete.png');
                                        } elseif($producto->tipo == 'Cooler') {
                                            $imagenUrl = asset('imagenes/productos/coolers/cooler.png');
                                        } elseif($producto->tipo == 'Monitor') {
                                            $imagenUrl = asset('imagenes/productos/monitors/monitor.png');
                                        } elseif($producto->tipo == 'periferico') {
                                            if(str_contains(strtolower($producto->name), 'mouse') && !str_contains(strtolower($producto->name), 'pad')) {
                                                $imagenUrl = asset('imagenes/productos/peripherals/mouse.png');
                                            } elseif(str_contains(strtolower($producto->name), 'mousepad')) {
                                                $imagenUrl = asset('imagenes/productos/peripherals/mousepad.png');
                                            } elseif(str_contains(strtolower($producto->name), 'auriculares') || str_contains(strtolower($producto->name), 'headset')) {
                                                $imagenUrl = asset('imagenes/productos/peripherals/auriculares.png');
                                            } else {
                                                $imagenUrl = asset('imagenes/productos/peripherals/gaming-peripheral.png');
                                            }
                                        }
                                    @endphp
                                    <img src="{{ $imagenUrl }}" alt="{{ $producto->name }}">
                                </div>
                                
                                <div class="p-2 p-md-3 d-flex flex-column">
                                    <div class="d-flex justify-content-between align-items-start mb-2 flex-wrap gap-1">
                                        <span class="badge-category">{{ $producto->tipo ?? 'Componente' }}</span>
                                        @auth
                                            @if(auth()->user()->rol == 'admin')
                                                <span class="badge bg-primary bg-opacity-25 text-white small">
                                                    Stock: {{ $producto->stocks->sum('cantidad') }}
                                                </span>
                                            @endif
                                        @endauth
                                    </div>
                                    <h6 class="fw-bold text-white mb-1" style="font-size: 0.85rem;">{{ $producto->name }}</h6>
                                    <span class="product-sku mb-2">{{ $producto->sku }}</span>
                                    <div class="mt-2 d-flex justify-content-between align-items-center flex-wrap gap-2">
                                        <span class="fw-bold fs-5" style="color: #0095f6;">
                                            ${{ number_format($producto->precio_venta, 0, ',', '.') }}
                                        </span>
                                        <a href="{{ route('productos.show', $producto->id) }}" 
                                           class="btn btn-outline-pixelfed btn-sm">
                                            Detalles <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                @if(method_exists($productos, 'links'))
                    <div class="mt-4 mt-md-5 d-flex justify-content-center">
                        {{ $productos->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-2 mb-0">No hay productos en esta categoría.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    // Toggle para el filtro en móvil
    document.getElementById('btnFilterMobile')?.addEventListener('click', function() {
        document.getElementById('sidebarCategories').classList.toggle('show');
    });
</script>
@endsection