@extends('layouts.app')

@section('content')
<style>
    
    .detail-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        transition: border-color 0.3s ease;
        height: 100%;
    }

    .detail-card:hover {
        border-color: var(--primary);
    }

    .product-image-placeholder {
        background: var(--bg-base); /* Fondo oscuro para que resalte la imagen */
        border-radius: 0.75rem;
        min-height: 280px;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
        border: 1px solid var(--border-color);
    }

    .product-image-placeholder img {
        max-width: 100%;
        max-height: 260px;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
        margin: 0 auto;
    }

    /* Tabla de especificaciones */
    .spec-table {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 1rem;
        overflow: hidden;
        width: 100%;
    }

    .spec-table td {
        padding: 0.6rem 0.8rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        color: #e0e0e0;
        font-size: 0.85rem;
    }

    /* Stock por sucursal */
    .stock-branch-item {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 0.75rem;
        padding: 0.6rem 0.8rem;
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s;
    }

    .stock-branch-name {
        font-weight: 500;
        color: #fff;
        font-size: 0.85rem;
    }

    .stock-branch-cantidad {
        background: rgba(0, 149, 246, 0.2);
        padding: 0.2rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: #0095f6;
    }

    /* Contenedor de stock con scroll */
    .stock-list-container {
        max-height: 180px;
        overflow-y: auto;
        padding-right: 0.25rem;
    }

    /* Personalizar scrollbar */
    .stock-list-container::-webkit-scrollbar {
        width: 4px;
    }

    .stock-list-container::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 4px;
    }

    .stock-list-container::-webkit-scrollbar-thumb {
        background: #0095f6;
        border-radius: 4px;
    }

    /* Botones */
    .btn-pixelfed-primary {
        background: linear-gradient(135deg, #0095f6, #00c3ff);
        border: none;
        border-radius: 2rem;
        padding: 0.5rem 1rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
        width: 100%;
    }

    .btn-pixelfed-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1.25rem rgba(0, 149, 246, 0.4);
    }

    .btn-pixelfed-outline {
        border: 1px solid rgba(0, 149, 246, 0.5);
        background: transparent;
        color: #0095f6;
        border-radius: 2rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
        font-size: 0.85rem;
        transition: all 0.2s;
        width: 100%;
    }

    .btn-pixelfed-outline:hover {
        background: rgba(0, 149, 246, 0.1);
        color: #0095f6;
    }

    /* Breadcrumb */
    .breadcrumb-pixelfed {
        background: rgba(15, 25, 45, 0.4);
        backdrop-filter: blur(8px);
        padding: 0.6rem 1rem;
        border-radius: 0.75rem;
        border: 1px solid rgba(255, 255, 255, 0.05);
        font-size: 0.85rem;
    }

    /* Precio */
    .price-main {
        font-size: clamp(1.5rem, 4vw, 1.8rem);
        font-weight: 800;
        color: #0095f6;
    }

    /* Títulos */
    h1 {
        font-size: clamp(1.2rem, 4vw, 1.6rem);
        font-weight: 700;
    }

    h5 {
        font-size: clamp(1rem, 3.5vw, 1.1rem);
    }

    h6 {
        font-size: clamp(0.85rem, 3vw, 0.95rem);
    }

    /* Badges */
    .badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.8rem;
    }

    /* Modal */
    .modal-pixelfed .modal-content {
        background: rgba(15, 25, 45, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(0, 149, 246, 0.3);
        border-radius: 1.5rem;
    }

    .form-select-pixelfed {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0.75rem;
        color: white;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
    }

    /* ============================================ */
    /* MEDIA QUERIES RESPONSIVAS                    */
    /* ============================================ */
    
    /* Móvil */
    @media (max-width: 576px) {
        .container {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        
        .detail-card {
            border-radius: 1rem;
        }
        
        .detail-card.p-4 {
            padding: 1rem !important;
        }
        
        .detail-card.p-3 {
            padding: 0.8rem !important;
        }
        
        .product-image-placeholder {
            min-height: 180px;
        }
        
        .product-image-placeholder img {
            max-height: 150px;
        }
        
        .btn-pixelfed-primary, .btn-pixelfed-outline {
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
        }
        
        .price-main {
            font-size: 1.4rem;
        }
        
        .breadcrumb-pixelfed {
            font-size: 0.7rem;
            padding: 0.5rem 0.8rem;
        }
        
        .stock-list-container {
            max-height: 140px;
        }
    }

    /* Tablet */
    @media (min-width: 577px) and (max-width: 768px) {
        .product-image-placeholder {
            min-height: 220px;
        }
        
        .product-image-placeholder img {
            max-height: 190px;
        }
        
        .btn-pixelfed-primary, .btn-pixelfed-outline {
            padding: 0.5rem 0.9rem;
            font-size: 0.8rem;
        }
        
        .stock-list-container {
            max-height: 160px;
        }
    }

    /* LAPTOP (rango específico) */
    @media (min-width: 769px) and (max-width: 1024px) {
        .product-image-placeholder {
            min-height: 240px;
        }
        
        .product-image-placeholder img {
            max-height: 200px;
        }
        
        .btn-pixelfed-primary, .btn-pixelfed-outline {
            padding: 0.45rem 0.8rem;
            font-size: 0.8rem;
        }
        
        .detail-card.p-4 {
            padding: 1rem !important;
        }
        
        h1 {
            font-size: 1.3rem;
        }
        
        .price-main {
            font-size: 1.5rem;
        }
        
        .stock-list-container {
            max-height: 150px;
        }
        
        .stock-branch-item {
            padding: 0.4rem 0.6rem;
        }
        
        .stock-branch-name {
            font-size: 0.75rem;
        }
        
        .stock-branch-cantidad {
            font-size: 0.7rem;
            padding: 0.15rem 0.5rem;
        }
    }

    /* Desktop pequeño */
    @media (min-width: 1025px) and (max-width: 1200px) {
        .product-image-placeholder {
            min-height: 260px;
        }
        
        .product-image-placeholder img {
            max-height: 220px;
        }
        
        .btn-pixelfed-primary, .btn-pixelfed-outline {
            padding: 0.55rem 1rem;
            font-size: 0.85rem;
        }
        
        .stock-list-container {
            max-height: 170px;
        }
    }

    /* Desktop grande */
    @media (min-width: 1201px) {
        .product-image-placeholder {
            min-height: 320px;
        }
        
        .product-image-placeholder img {
            max-height: 280px;
        }
        
        .btn-pixelfed-primary, .btn-pixelfed-outline {
            padding: 0.7rem 1.2rem;
            font-size: 0.9rem;
        }
        
        .stock-list-container {
            max-height: 200px;
        }
    }
</style>

<div class="container py-3 py-md-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3 mb-md-4">
        <ol class="breadcrumb breadcrumb-pixelfed">
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}"><i class="bi bi-grid me-1"></i>Productos</a></li>
            <li class="breadcrumb-item active text-capitalize">{{ $product->tipo }}</li>
        </ol>
    </nav>

    <div class="row g-3 g-md-4">
        <!-- Columna izquierda: Imagen -->
        <div class="col-12 col-md-5">
            <div class="detail-card p-2 p-md-3">
                <div class="product-image-placeholder">
                    @php
                        $imagenUrl = asset('imagenes/productos/default-hardware.png');
                        if(str_contains(strtolower($product->name), 'ryzen')) {
                            $imagenUrl = asset('imagenes/productos/cpus/amd-ryzen.png');
                        } elseif(str_contains(strtolower($product->name), 'core i')) {
                            $imagenUrl = asset('imagenes/productos/cpus/intel-core.png');
                        } elseif($product->tipo == 'Placa') {
                            $imagenUrl = asset('imagenes/productos/mothers/motherboard.png');
                        } elseif($product->tipo == 'RAM') {
                            $imagenUrl = asset('imagenes/productos/ram/ram-ddr.png');
                        } elseif($product->tipo == 'GPU') {
                            $imagenUrl = str_contains(strtolower($product->name), 'rtx') 
                                ? asset('imagenes/productos/gpus/nvidia-rtx.png')
                                : asset('imagenes/productos/gpus/amd-radeon.png');
                        } elseif($product->tipo == 'SSD') {
                            $imagenUrl = asset('imagenes/productos/ssd/ssd-m2.png');
                        } elseif($product->tipo == 'Gabinete') {
                            $imagenUrl = asset('imagenes/productos/cases/gabinete.png');
                        } elseif($product->tipo == 'Cooler') {
                            $imagenUrl = asset('imagenes/productos/coolers/cooler.png');
                        } elseif($product->tipo == 'Monitor') {
                            $imagenUrl = asset('imagenes/productos/monitors/monitor.png');
                        } elseif($product->tipo == 'periferico') {
                            if(str_contains(strtolower($product->name), 'mouse') && !str_contains(strtolower($product->name), 'pad')) {
                                $imagenUrl = asset('imagenes/productos/peripherals/mouse.png');
                            } elseif(str_contains(strtolower($product->name), 'mousepad')) {
                                $imagenUrl = asset('imagenes/productos/peripherals/mousepad.png');
                            } elseif(str_contains(strtolower($product->name), 'auriculares') || str_contains(strtolower($product->name), 'headset')) {
                                $imagenUrl = asset('imagenes/productos/peripherals/auriculares.png');
                            } else {
                                $imagenUrl = asset('imagenes/productos/peripherals/gaming-peripheral.png');
                            }
                        }
                    @endphp
                    <img src="{{ $imagenUrl }}" alt="{{ $product->name }}">
                </div>
            </div>
        </div>

        <!-- Columna central: Info del producto -->
        <div class="col-12 col-md-4">
            <div class="detail-card p-3 p-md-4 h-100">
                <h1 class="fw-bold text-white mb-2">{{ $product->name }}</h1>
                <p class="text-secondary mb-3" style="font-size: 0.85rem;">
                    <i class="bi bi-upc-scan me-1"></i>SKU: <span class="product-sku">{{ $product->sku }}</span>
                </p>
                <hr class="border-secondary">
                
                <div class="price-main mb-2">
                    ${{ number_format($product->precio_venta, 0, ',', '.') }}
                </div>
                <p class="small text-success mb-3">
                    <i class="bi bi-check-circle-fill"></i> Precio incluye impuestos
                </p>

                <!-- Especificaciones Técnicas -->
                @if($product->compatibility && ($product->compatibility->tipo_socket || $product->compatibility->tipo_ram))
                    <div class="mt-3 mt-md-4">
                        <h5 class="text-white mb-2 mb-md-3">
                            <i class="bi bi-gear-wide-connected me-2 text-primary"></i>Especificaciones Técnicas
                        </h5>
                        <table class="spec-table w-100">
                            @if($product->compatibility->tipo_socket)
                                <tr>
                                    <td class="fw-bold text-secondary" style="width: 40%;">Socket</td>
                                    <td><span class="badge bg-primary bg-opacity-25 text-primary">{{ $product->compatibility->tipo_socket }}</span></td>
                                </tr>
                            @endif
                            @if($product->compatibility->tipo_ram)
                                <tr>
                                    <td class="fw-bold text-secondary">Tipo de RAM</td>
                                    <td><span class="badge bg-primary bg-opacity-25 text-primary">{{ $product->compatibility->tipo_ram }}</span></td>
                                </tr>
                            @endif
                        </table>
                    </div>
                @endif
            </div>
        </div>

        <!-- Columna derecha: Compra y Stock -->
        <div class="col-12 col-md-3">
            <div class="detail-card p-3 p-md-4">
                <div class="text-center mb-3">
                    <span class="badge bg-success bg-opacity-25 text-success py-2 px-3 rounded-pill">
                        <i class="bi bi-check-circle"></i> Disponible ahora
                    </span>
                </div>

                <div class="d-grid gap-2 mb-3 mb-md-4">
                    <button type="button" class="btn btn-pixelfed-outline" disabled>
                        <i class="bi bi-cart me-2"></i>Añadir al carrito
                    </button>
                    <button type="button" class="btn btn-pixelfed-primary" 
                            data-bs-toggle="modal" 
                            data-bs-target="#confirmarCompraModal">
                        <i class="bi bi-lightning-charge me-2"></i>Comprar ahora
                    </button>
                </div>

                <hr class="border-secondary">

                <!-- Stock por Sucursal con scroll -->
                <h6 class="text-white mb-2 mb-md-3">
                    <i class="bi bi-building me-2 text-primary"></i>Disponibilidad por sucursal
                </h6>
                @auth
                    @if(auth()->user()->rol == 'admin')
                        <div class="stock-list-container">
                            @foreach($product->stocks as $stock)
                                <div class="stock-branch-item">
                                    <span class="stock-branch-name">
                                        <i class="bi bi-geo-alt-fill text-primary me-2" style="font-size: 0.7rem;"></i>
                                        {{ $stock->branch->name }}
                                    </span>
                                    <span class="stock-branch-cantidad">{{ $stock->cantidad }} unidades</span>
                                </div>
                            @endforeach
                        </div>
                        <div class="alert alert-info bg-opacity-10 text-info small mt-3 mb-0 rounded-3" style="background: rgba(0,149,246,0.1); border: 1px solid rgba(0,149,246,0.2); font-size: 0.7rem;">
                            <i class="bi bi-shield-lock me-1"></i> Modo Administrador - Stock visible
                        </div>
                    @else
    <p class="text-secondary small mb-0" style="font-size: 0.8rem;">
        <i class="bi bi-check-circle-fill text-success me-1"></i>
        Hay unidades disponibles en tu sucursal más cercana.
    </p>
    <a href="#footer-sucursales" class="btn btn-link text-primary p-0 mt-2 small" style="font-size: 0.8rem;">
        Ver sucursales <i class="bi bi-arrow-right"></i>
    </a>
@endif
                @else
                    <p class="text-secondary small mb-2" style="font-size: 0.8rem;">
                        <i class="bi bi-info-circle me-1"></i>
                        Inicia sesión para ver disponibilidad en sucursales.
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-pixelfed-outline w-100 mt-2">
                        Iniciar Sesión
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación de Compra -->
<div class="modal fade modal-pixelfed" id="confirmarCompraModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title fw-bold text-white">
                    <i class="bi bi-cart-check text-primary me-2"></i>Confirmar Pedido
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-cpu text-primary display-4"></i>
                </div>
                <p class="text-secondary mb-2">Estás a punto de comprar:</p>
                <h5 class="text-white fw-bold">{{ $product->name }}</h5>
                <h3 class="text-primary fw-bold mt-2" style="font-size: clamp(1.2rem, 5vw, 1.8rem);">${{ number_format($product->precio_venta, 0, ',', '.') }}</h3>
            </div>
            
            <div class="modal-footer border-0">
    <button type="button" class="btn btn-pixelfed-outline" data-bs-dismiss="modal">Cancelar</button>
    <form action="{{ route('ventas.store_express') }}" method="POST" class="w-100">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="hidden" name="cantidad" value="1">

        <div class="mb-3 text-start">
            <label class="form-label text-white fw-bold mb-2" style="font-size: 0.85rem;">
                <i class="bi bi-building me-1"></i>Seleccionar Sucursal:
            </label>
            <select name="sucursal_id" class="form-select form-select-pixelfed" required>
                @foreach($sucursales as $sucursal)
                    <option value="{{ $sucursal->id }}">{{ $sucursal->name }}</option>
                @endforeach
            </select>
        </div>

        @auth
            @php
                $descuentos = \App\Models\Descuento::where('user_id', auth()->id())
                    ->where('usado', false)
                    ->get();
            @endphp
            
            @if($descuentos->count() > 0)
                <div class="mb-3 text-start">
                    <label class="form-label text-white fw-bold mb-2" style="font-size: 0.85rem;">
                        <i class="bi bi-ticket-perforated me-1"></i>Descuentos disponibles:
                    </label>
                    <select name="descuento_id" class="form-select form-select-pixelfed">
                        <option value="">Sin descuento</option>
                        @foreach($descuentos as $descuento)
                            <option value="{{ $descuento->id }}">
                                {{ $descuento->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
        @endauth

        <button type="submit" class="btn btn-pixelfed-primary w-100">
            <i class="bi bi-check-circle me-2"></i>Confirmar Compra
        </button>
    </form>
</div>
        </div>
    </div>
</div>
@endsection