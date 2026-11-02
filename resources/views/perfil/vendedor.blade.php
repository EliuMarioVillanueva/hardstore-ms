@extends('layouts.app')

@section('content')
<style>
    .profile-card {
        background: rgba(15, 25, 45, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.5rem;
        overflow: hidden;
        height: 100%;
    }

    .profile-header {
        background: linear-gradient(135deg, rgba(0, 149, 246, 0.15), rgba(0, 195, 255, 0.05));
        padding: 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .profile-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #0095f6, #00c3ff);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .profile-avatar i {
        font-size: 2.5rem;
        color: white;
    }

    .stat-card-profile {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 1rem;
        padding: 1rem;
        text-align: center;
    }

    .stat-number-profile {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0095f6;
    }

    .btn-outline-pixelfed {
        background: transparent;
        border: 1px solid rgba(0, 149, 246, 0.5);
        color: #0095f6;
        border-radius: 40px;
        padding: 0.4rem 1rem;
        transition: all 0.2s;
    }

    .btn-outline-pixelfed:hover {
        background: #0095f6;
        color: white;
    }

    /* Pestañas */
    .nav-tabs-custom {
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0 1rem;
    }

    .nav-tabs-custom .nav-link {
        color: #a0a0b0;
        border: none;
        padding: 0.8rem 1.2rem;
        font-weight: 500;
        transition: all 0.2s;
        position: relative;
    }

    .nav-tabs-custom .nav-link:hover {
        color: white;
        background: transparent;
    }

    .nav-tabs-custom .nav-link.active {
        color: #0095f6;
        background: transparent;
    }

    .nav-tabs-custom .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 2px;
        background: #0095f6;
    }

    /* Tabla de inventario */
    .inventario-table {
        width: 100%;
        font-size: 0.8rem;
    }

    .inventario-table th, .inventario-table td {
        padding: 0.6rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .stock-input {
        width: 80px;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 0.3rem 0.6rem;
        color: white;
        text-align: center;
    }

    .btn-save {
        background: transparent;
        border: 1px solid #0095f6;
        color: #0095f6;
        border-radius: 20px;
        padding: 0.3rem 0.6rem;
        cursor: pointer;
    }

    .btn-save:hover {
        background: #0095f6;
        color: white;
    }

    /* Scroll en tablas */
    .table-scroll {
        max-height: 400px;
        overflow-y: auto;
    }

    .table-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .table-scroll::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 4px;
    }

    .table-scroll::-webkit-scrollbar-thumb {
        background: #0095f6;
        border-radius: 4px;
    }

    @media (max-width: 768px) {
        .inventario-table thead {
            display: none;
        }
        .inventario-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            background: rgba(15, 25, 45, 0.4);
            border-radius: 1rem;
        }
        .inventario-table tbody td {
            display: flex;
            justify-content: space-between;
            padding: 0.6rem;
        }
        .inventario-table tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #0095f6;
            font-size: 0.7rem;
        }
    }
</style>

<div class="container py-4">
    <div class="row g-4">
        <!-- Columna izquierda: Información del vendedor (fija) -->
        <div class="col-md-4">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <h4 class="text-white mb-1">{{ $user->name }}</h4>
                    <p class="text-secondary small mb-0">{{ $user->email }}</p>
                    <span class="badge bg-primary bg-opacity-25 text-primary mt-2">
                        <i class="bi bi-building me-1"></i>{{ $user->branch->name ?? 'Sin sucursal' }}
                    </span>
                </div>
                <div class="p-4">
                    <div class="stat-card-profile mb-3">
                        <div class="stat-number-profile">${{ number_format($totalVentasSucursal, 0, ',', '.') }}</div>
                        <div class="small text-secondary">Total ventas</div>
                    </div>
                    <div class="stat-card-profile mb-3">
                        <div class="stat-number-profile">{{ $cantidadVentasSucursal }}</div>
                        <div class="small text-secondary">Ventas realizadas</div>
                    </div>
                    <div class="stat-card-profile">
                        <div class="stat-number-profile">{{ $productosVendidosSucursal }}</div>
                        <div class="small text-secondary">Productos vendidos</div>
                    </div>
                    
                    <hr class="border-secondary my-4">
                    
                    <a href="{{ route('perfil.editar') }}" class="btn btn-outline-pixelfed w-100">
                        <i class="bi bi-pencil-square me-2"></i>Editar Perfil
                    </a>
                </div>
            </div>
        </div>

        <!-- Columna derecha: Pestañas -->
        <div class="col-md-8">
            <div class="profile-card">
                <!-- Pestañas -->
                <ul class="nav nav-tabs-custom" id="perfilTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="resumen-tab" data-bs-toggle="tab" data-bs-target="#resumen" type="button" role="tab">
                            <i class="bi bi-speedometer2 me-2"></i>Resumen
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="inventario-tab" data-bs-toggle="tab" data-bs-target="#inventario" type="button" role="tab">
                            <i class="bi bi-box-seam me-2"></i>Inventario
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="ventas-tab" data-bs-toggle="tab" data-bs-target="#ventas" type="button" role="tab">
                            <i class="bi bi-receipt me-2"></i>Ventas
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pendientes-tab" data-bs-toggle="tab" data-bs-target="#pendientes" type="button" role="tab">
                        <i class="bi bi-clock-history me-2"></i>Pendientes
                        </button>
                    </li>
                </ul>

                <!-- Contenido de las pestañas -->
                <div class="tab-content p-3">
                    <!-- Pestaña Resumen -->
                    <div class="tab-pane fade show active" id="resumen" role="tabpanel">
                        <div class="row g-3">
                            <div class="col-12">
                                <h6 class="text-white mb-3"><i class="bi bi-graph-up me-2 text-primary"></i>Resumen de mi Sucursal</h6>
                                <div class="row g-3">
                                    <div class="col-4">
                                        <div class="stat-card-profile">
                                            <div class="stat-number-profile">{{ $totalProductos }}</div>
                                            <div class="small text-secondary">Productos</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-card-profile">
                                            <div class="stat-number-profile">{{ $totalUnidades }}</div>
                                            <div class="small text-secondary">Unidades</div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="stat-card-profile">
                                            <div class="stat-number-profile" style="color: #ffc107;">{{ $productosBajoStock }}</div>
                                            <div class="small text-secondary">Stock bajo</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="d-flex justify-content-center gap-3 mt-3">
                                    <a href="{{ route('perfil.reporte.inventario') }}" class="btn btn-outline-pixelfed" target="_blank">
                                        <i class="bi bi-file-pdf me-1"></i>Reporte Inventario
                                    </a>
                                    <a href="{{ route('perfil.reporte.ventas') }}" class="btn btn-outline-pixelfed" target="_blank">
                                        <i class="bi bi-file-pdf me-1"></i>Reporte Ventas
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña Inventario -->
                    <div class="tab-pane fade" id="inventario" role="tabpanel">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('perfil.reporte.inventario') }}" class="btn btn-outline-pixelfed btn-sm" target="_blank">
                                <i class="bi bi-file-pdf me-1"></i>Reporte PDF
                            </a>
                        </div>
                        <div class="table-scroll">
                            <table class="inventario-table">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>SKU</th>
                                        <th>Stock</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productos as $producto)
                                    @php $stockActual = $producto->stocks->first()->cantidad ?? 0; @endphp
                                    <tr>
                                        <td data-label="Producto">{{ $producto->name }}</td>
                                        <td data-label="SKU"><code>{{ $producto->sku }}</code></td>
                                        <td data-label="Stock">
                                            <input type="number" id="stock-{{ $producto->id }}" class="stock-input" value="{{ $stockActual }}" min="0">
                                        </td>
                                        <td data-label="Acción">
                                            <button onclick="updateStock({{ $producto->id }}, {{ $sucursalId }})" class="btn-save" id="btn-{{ $producto->id }}">
                                                <i class="bi bi-save"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pestaña Ventas -->
                    <div class="tab-pane fade" id="ventas" role="tabpanel">
                        <div class="d-flex justify-content-end mb-3">
                            <a href="{{ route('perfil.reporte.ventas') }}" class="btn btn-outline-pixelfed btn-sm" target="_blank">
                                <i class="bi bi-file-pdf me-1"></i>Reporte PDF
                            </a>
                        </div>
                        <div class="table-scroll">
                            @if($ventasRecientes->count() > 0)
                                <table class="inventario-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Producto</th>
                                            <th>Total</th>
                                            <th>Vendedor</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ventasRecientes as $venta)
                                            @foreach($venta->detalles as $detalle)
                                            <tr>
                                                <td data-label="ID">#{{ $venta->id }}</td>
                                                <td data-label="Fecha">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                                                <td data-label="Producto">{{ $detalle->producto->name ?? 'Producto' }} (x{{ $detalle->cantidad }})</td>
                                                <td data-label="Total" class="fw-bold" style="color: #0095f6;">${{ number_format($detalle->cantidad * $detalle->precio_unitario_historico, 0, ',', '.') }}</td>
                                                <td data-label="Vendedor">{{ $venta->usuario->name ?? 'N/A' }}</td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">No hay ventas en tu sucursal.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Pestaña Pendientes -->
<div class="tab-pane fade" id="pendientes" role="tabpanel">
    <div class="d-flex justify-content-end mb-3">
        <span class="badge bg-warning bg-opacity-25 text-warning">
            <i class="bi bi-clock me-1"></i>{{ $ventasPendientes->count() ?? 0 }} pendientes
        </span>
    </div>
    <div class="table-scroll">
        @if(isset($ventasPendientes) && $ventasPendientes->count() > 0)
            <table class="inventario-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Producto</th>
                        <th>Monto</th>
                        <th>Fecha</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasPendientes as $venta)
                    <tr>
                        <td data-label="ID">#{{ $venta->id }}</td>
                        <td data-label="Cliente">{{ $venta->usuario->name }}</td>
                        <td data-label="Producto">{{ $venta->detalles->first()->producto->name }}</td>
                        <td data-label="Monto" class="fw-bold" style="color: #0095f6;">${{ number_format($venta->total, 0, ',', '.') }}</td>
                        <td data-label="Fecha">{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                        <td data-label="Acción">
                            <form action="{{ route('ventas.confirmar', $venta->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm w-100" style="background: linear-gradient(135deg, #28a745, #20c997); border: none; color: white; border-radius: 2rem; padding: 0.3rem 0.8rem; font-weight: 600;">
                                    <i class="bi bi-check-circle me-1"></i>Confirmar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="text-center py-4">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <p class="text-muted mt-2 mb-0">No hay ventas pendientes.</p>
            </div>
        @endif
    </div>
</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateStock(productoId, sucursalId) {
    const cantidad = document.getElementById('stock-' + productoId).value;
    const btn = document.getElementById('btn-' + productoId);
    const originalHtml = btn.innerHTML;
    
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
    btn.disabled = true;
    
    fetch(`/inventario-ajax/${productoId}`, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            cantidad: cantidad,
            sucursal_id: sucursalId
        })
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            btn.innerHTML = '<i class="bi bi-check-lg"></i>';
            btn.style.background = '#28a745';
            btn.style.borderColor = '#28a745';
            btn.style.color = 'white';
            setTimeout(() => {
                btn.innerHTML = originalHtml;
                btn.style.background = '';
                btn.style.borderColor = '';
                btn.style.color = '';
                btn.disabled = false;
            }, 1500);
        } else {
            throw new Error('Error');
        }
    })
    .catch(error => {
        alert('Error al actualizar el stock');
        btn.innerHTML = originalHtml;
        btn.disabled = false;
    });
}
</script>
@endsection