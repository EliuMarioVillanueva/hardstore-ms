{{-- resources/views/productos/stock.blade.php --}}
@extends('layouts.app')

@section('content')
<style>
    /* Estilos específicos para gestión de inventario estilo Pixelfed */
    .stock-card {
        background: rgba(15, 25, 45, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 24px;
        overflow: hidden;
    }

    .stock-header {
        background: linear-gradient(135deg, rgba(0, 149, 246, 0.15), rgba(0, 195, 255, 0.05));
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding: 1.5rem;
    }

    .branch-selector {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 40px;
        padding: 0.5rem 1rem;
        color: white;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
    }

    .branch-selector:hover {
        border-color: #0095f6;
    }

    .branch-selector:focus {
        border-color: #0095f6;
        box-shadow: 0 0 0 2px rgba(0, 149, 246, 0.2);
        outline: none;
    }

    /* Tabla estilo Pixelfed */
    .pixelfed-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .pixelfed-table thead th {
        background: rgba(0, 0, 0, 0.3);
        color: #a0a0b0;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .pixelfed-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .pixelfed-table tbody tr:hover {
        background: rgba(0, 149, 246, 0.05);
    }

    .pixelfed-table tbody td {
        padding: 1rem;
        color: #e0e0e0;
        vertical-align: middle;
    }

    /* Badges de stock */
    .badge-stock-high {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
        padding: 0.35rem 0.75rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-stock-low {
        background: rgba(220, 53, 69, 0.15);
        color: #dc3545;
        padding: 0.35rem 0.75rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-stock-medium {
        background: rgba(255, 193, 7, 0.15);
        color: #ffc107;
        padding: 0.35rem 0.75rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .badge-sede {
        background: rgba(0, 149, 246, 0.15);
        color: #0095f6;
        padding: 0.35rem 0.75rem;
        border-radius: 40px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    /* Input de stock */
    .stock-input {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 40px;
        padding: 0.4rem 0.75rem;
        width: 90px;
        text-align: center;
        color: white;
        font-weight: 500;
        transition: all 0.2s;
    }

    .stock-input:focus {
        border-color: #0095f6;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 149, 246, 0.2);
    }

    .btn-save-stock {
        background: transparent;
        border: 1px solid rgba(0, 149, 246, 0.5);
        color: #0095f6;
        border-radius: 40px;
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-save-stock:hover {
        background: #0095f6;
        color: white;
        transform: scale(1.05);
    }

    /* Resumen de inventario */
    .inventory-summary {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 16px;
        padding: 1rem;
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .summary-item {
        flex: 1;
        text-align: center;
        padding: 0.75rem;
        background: rgba(0, 0, 0, 0.2);
        border-radius: 12px;
    }

    .summary-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0095f6;
    }

    .summary-label {
        font-size: 0.7rem;
        color: #a0a0b0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Breadcrumb */
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

    /* Responsive */
    @media (max-width: 768px) {
        .pixelfed-table thead {
            display: none;
        }
        .pixelfed-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border-radius: 16px;
            background: rgba(15, 25, 45, 0.4);
        }
        .pixelfed-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .pixelfed-table tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #0095f6;
            font-size: 0.75rem;
        }
    }
</style>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-pixelfed">
            <li class="breadcrumb-item"><a href="{{ route('productos.index') }}"><i class="bi bi-grid me-1"></i>Productos</a></li>
            <li class="breadcrumb-item active">Gestión de Inventario</li>
        </ol>
    </nav>

    <!-- Header y selector de sucursal -->
    <div class="stock-card">
        <div class="stock-header">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <h2 class="fw-bold mb-1 text-white">
                <i class="bi bi-boxes me-2" style="color: #0095f6;"></i>
                Gestión de Inventario
            </h2>
            <p class="text-secondary mb-0 small">
                Administra el stock por sucursal en tiempo real
            </p>
        </div>
        <div class="d-flex align-items-center gap-3">
    <a href="{{ route('reporte.inventario') }}" class="btn btn-primary-pixelfed" target="_blank" style="background: linear-gradient(135deg, #0095f6, #00c3ff); border: none; border-radius: 40px; padding: 0.5rem 1.2rem; font-weight: 600;">
        <i class="bi bi-file-pdf me-2"></i> Reporte PDF
    </a>
    <div class="d-flex align-items-center gap-2">
        <i class="bi bi-building text-primary"></i>
        <select class="branch-selector" 
                onchange="location.href = '{{ route('productos.stock') }}?sucursal_id=' + this.value">
            @foreach($sucursales as $sucursal)
                <option value="{{ $sucursal->id }}" 
                    style="background: #0a0e27;"
                    {{ (isset($sucursalId) && $sucursalId == $sucursal->id) ? 'selected' : '' }}>
                    {{ $sucursal->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>
    </div>
</div>

        <!-- Resumen de inventario -->
        <div class="p-4 border-bottom" style="border-color: rgba(255,255,255,0.05);">
            @php
                $totalProductos = $productos->count();
                $totalStock = $productos->sum(function($p) { 
                    return $p->stocks->first()->cantidad ?? 0; 
                });
                $productosBajoStock = $productos->filter(function($p) { 
                    return ($p->stocks->first()->cantidad ?? 0) < 5; 
                })->count();
            @endphp
            <div class="inventory-summary">
                <div class="summary-item">
                    <div class="summary-number">{{ $totalProductos }}</div>
                    <div class="summary-label">Productos distintos</div>
                </div>
                <div class="summary-item">
                    <div class="summary-number">{{ $totalStock }}</div>
                    <div class="summary-label">Unidades totales</div>
                </div>
                <div class="summary-item">
                    <div class="summary-number" style="color: #ffc107;">{{ $productosBajoStock }}</div>
                    <div class="summary-label">Stock bajo (&lt;5)</div>
                </div>
            </div>
        </div>

        <!-- Tabla de inventario -->
        <div class="table-responsive">
            <table class="pixelfed-table">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Producto</th>
                        <th>Sede Actual</th>
                        <th class="text-center">Stock Actual</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($productos as $producto)
                    @php 
                        $registroStock = $producto->stocks->first();
                        $stockActual = $registroStock->cantidad ?? 0; 
                        $nombreSede = $registroStock && $registroStock->branch ? $registroStock->branch->name : 'Sin sede';
                        
                        if($stockActual >= 20) {
                            $stockClass = 'badge-stock-high';
                            $stockText = 'Alto';
                        } elseif($stockActual >= 5) {
                            $stockClass = 'badge-stock-medium';
                            $stockText = 'Medio';
                        } else {
                            $stockClass = 'badge-stock-low';
                            $stockText = 'Bajo';
                        }
                    @endphp
                    <tr>
                        <td data-label="SKU">
                            <code style="color: #0095f6;">{{ $producto->sku }}</code>
                        </td>
                        <td data-label="Producto">
                            <span class="fw-bold text-white">{{ $producto->name }}</span>
                        </td>
                        <td data-label="Sede">
                            <span class="badge-sede">
                                <i class="bi bi-building me-1"></i>{{ $nombreSede }}
                            </span>
                        </td>
                        <td data-label="Stock" class="text-center">
                            <span class="{{ $stockClass }}">
                                {{ $stockActual }} unidades ({{ $stockText }})
                            </span>
                        </td>
                        <td data-label="Acciones">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <input type="number" 
                                       id="input-stock-{{ $producto->id }}" 
                                       class="stock-input" 
                                       value="{{ $stockActual }}" 
                                       min="0"
                                       step="1">
                                
                                <button onclick="updateStock({{ $producto->id }}, {{ $sucursalId ?? 1 }})" 
                                        id="btn-{{ $producto->id }}"
                                        class="btn-save-stock"
                                        title="Actualizar stock">
                                    <i class="bi bi-save"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if($productos->count() == 0)
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2 mb-0">No hay productos en esta sucursal</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function updateStock(id, sucursalId) {
    const cantidad = document.getElementById('input-stock-' + id).value;
    const btn = document.getElementById('btn-' + id);
    const originalIcon = btn.innerHTML;
    
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i>';
    btn.disabled = true;

    fetch(`/inventario-ajax/${id}`, {
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
                btn.innerHTML = originalIcon;
                btn.style.background = '';
                btn.style.borderColor = '';
                btn.style.color = '';
                btn.disabled = false;
            }, 1500);
            
            setTimeout(() => {
                location.reload();
            }, 1000);
        } else {
            throw new Error(data.message || 'Error al actualizar');
        }
    })
    .catch(error => {
        alert('Error al actualizar el stock: ' + error.message);
        btn.innerHTML = originalIcon;
        btn.disabled = false;
    });
}
</script>
@endsection