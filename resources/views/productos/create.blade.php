@extends('layouts.app')

@section('content')
<style>
    /* Estilos específicos para formulario estilo Pixelfed */
    .form-card {
        background: rgba(15, 25, 45, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        overflow: hidden;
    }

    .form-card-header {
        background: linear-gradient(135deg, rgba(0, 149, 246, 0.15), rgba(0, 195, 255, 0.05));
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 1.5rem;
    }

    .form-card-body {
        padding: 2rem;
    }

    .form-label-pixelfed {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #a0a0b0;
        margin-bottom: 0.5rem;
    }

    .form-control-pixelfed, .form-select-pixelfed {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        color: white;
        transition: all 0.2s;
    }

    .form-control-pixelfed:focus, .form-select-pixelfed:focus {
        border-color: #0095f6;
        box-shadow: 0 0 0 3px rgba(0, 149, 246, 0.2);
        background: rgba(0, 0, 0, 0.5);
        color: white;
    }

    .form-control-pixelfed::placeholder {
        color: #6c757d;
    }

    .input-group-pixelfed {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        overflow: hidden;
    }

    .input-group-pixelfed .input-group-text {
        background: transparent;
        border: none;
        color: #0095f6;
        font-weight: 600;
        padding: 0.75rem 1rem;
    }

    .input-group-pixelfed .form-control-pixelfed {
        border: none;
        background: transparent;
    }

    .btn-pixelfed-primary {
        background: linear-gradient(135deg, #0095f6, #00c3ff);
        border: none;
        border-radius: 40px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-pixelfed-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 149, 246, 0.4);
    }

    .btn-pixelfed-secondary {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 40px;
        padding: 0.75rem 2rem;
        font-weight: 500;
        color: white;
        transition: all 0.2s;
    }

    .btn-pixelfed-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .breadcrumb-pixelfed {
        background: rgba(15, 25, 45, 0.4);
        backdrop-filter: blur(8px);
        padding: 0.75rem 1rem;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.05);
        margin-bottom: 1.5rem;
    }

    .breadcrumb-pixelfed .breadcrumb-item a {
        color: #0095f6;
        text-decoration: none;
    }

    .breadcrumb-pixelfed .breadcrumb-item.active {
        color: #a0a0b0;
    }

    .required-field::after {
        content: '*';
        color: #0095f6;
        margin-left: 4px;
    }
</style>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-pixelfed">
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}"><i class="bi bi-grid me-1"></i>Productos</a></li>
            <li class="breadcrumb-item active">Registrar Producto</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="fw-bold mb-0 text-white">
                        <i class="bi bi-plus-circle me-2" style="color: #0095f6;"></i>
                        Registrar Nuevo Producto
                    </h3>
                    <p class="text-secondary mb-0 mt-2 small">
                        Completa los datos del componente para añadirlo al inventario
                    </p>
                </div>
                
                <div class="form-card-body">
                    <form action="{{ route('productos.store') }}" method="POST">
                        @csrf

                        <div class="row g-4">
                            <!-- Nombre del Producto -->
                            <div class="col-12">
                                <label for="nombre" class="form-label-pixelfed required-field">Nombre del Componente</label>
                                <input type="text" 
                                       name="nombre" 
                                       id="nombre" 
                                       class="form-control form-control-pixelfed" 
                                       placeholder="Ej: NVIDIA RTX 4070 Ti, AMD Ryzen 7 5800X"
                                       required>
                                <small class="text-secondary mt-1 d-block">Nombre comercial completo del producto</small>
                            </div>

                            <!-- SKU y Categoría -->
                            <div class="col-md-6">
                                <label for="sku" class="form-label-pixelfed required-field">Código SKU</label>
                                <input type="text" 
                                       name="sku" 
                                       id="sku" 
                                       class="form-control form-control-pixelfed" 
                                       placeholder="Ej: GPU-NV-4070"
                                       required>
                                <small class="text-secondary mt-1 d-block">Código único de identificación</small>
                            </div>

                            <div class="col-md-6">
                                <label for="tipo" class="form-label-pixelfed required-field">Categoría</label>
                                <select name="tipo" id="tipo" class="form-select form-select-pixelfed" required>
                                    <option value="" selected disabled>Seleccionar categoría...</option>
                                    <option value="CPU">🖥️ Procesador (CPU)</option>
                                    <option value="GPU">🎮 Tarjeta de Video (GPU)</option>
                                    <option value="Placa">🔌 Placa Base</option>
                                    <option value="RAM">💾 Memoria RAM</option>
                                    <option value="SSD">💿 SSD / Almacenamiento</option>
                                    <option value="PSU">⚡ Fuente de Poder (PSU)</option>
                                    <option value="Gabinete">📦 Gabinete</option>
                                    <option value="Cooler">❄️ Cooler / Refrigeración</option>
                                    <option value="Monitor">🖥️ Monitor</option>
                                    <option value="periferico">🎧 Periférico</option>
                                </select>
                            </div>

                            <!-- Precio de Venta -->
                            <div class="col-md-6">
                                <label for="precio_venta" class="form-label-pixelfed required-field">Precio de Venta</label>
                                <div class="input-group input-group-pixelfed">
                                    <span class="input-group-text">$</span>
                                    <input type="number" 
                                           step="0.01" 
                                           name="precio_venta" 
                                           id="precio_venta" 
                                           class="form-control form-control-pixelfed" 
                                           placeholder="0.00"
                                           required>
                                </div>
                                <small class="text-secondary mt-1 d-block">Precio final al cliente (incluye impuestos)</small>
                            </div>

                            <!-- Stock Inicial -->
                            <div class="col-md-6">
                                <label for="cantidad_inicial" class="form-label-pixelfed">Stock Inicial</label>
                                <input type="number" 
                                       name="cantidad_inicial" 
                                       id="cantidad_inicial" 
                                       class="form-control form-control-pixelfed" 
                                       value="0" 
                                       min="0">
                                <small class="text-secondary mt-1 d-block">Cantidad inicial en la sucursal seleccionada</small>
                            </div>

                            <!-- Sucursal -->
                            <div class="col-12">
                                <label for="sucursal_id" class="form-label-pixelfed required-field">Sucursal de depósito</label>
                                <select name="sucursal_id" id="sucursal_id" class="form-select form-select-pixelfed" required>
                                    <option value="" selected disabled>Selecciona una sucursal...</option>
                                    @forelse($sucursales as $sucursal)
                                        <option value="{{ $sucursal->id }}">
                                            🏢 {{ $sucursal->nombre ?? $sucursal->name }}
                                            @if(isset($sucursal->ubicacion) || isset($sucursal->location))
                                                - ({{ $sucursal->ubicacion ?? $sucursal->location }})
                                            @endif
                                        </option>
                                    @empty
                                        <option disabled>⚠️ No hay sucursales registradas</option>
                                    @endforelse
                                </select>
                                <small class="text-secondary mt-1 d-block">El producto se almacenará inicialmente en esta sucursal</small>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="mt-5 d-flex gap-3 justify-content-end">
                            <a href="{{ route('productos.index') }}" class="btn btn-pixelfed-secondary">
                                <i class="bi bi-x-lg me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-pixelfed-primary">
                                <i class="bi bi-check-lg me-2"></i>Guardar Producto
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection