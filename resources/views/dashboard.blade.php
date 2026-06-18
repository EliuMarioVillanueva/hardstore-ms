@extends('layouts.app')

@section('content')
<style>
    /* Estilos Dashboard estilo Pixelfed */
    .dashboard-container {
        padding: 1.5rem;
        min-height: 100vh;
    }

    /* Tarjetas estilo Pixelfed */
    .px-card {
        background: rgba(15, 25, 45, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .px-card:hover {
        border-color: rgba(0, 149, 246, 0.3);
        transform: translateY(-3px);
    }

    /* KPI Cards */
    .kpi-icon {
        width: 48px;
        height: 48px;
        background: rgba(0, 149, 246, 0.15);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #0095f6;
    }

    .kpi-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: white;
        line-height: 1.2;
    }

    .kpi-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #a0a0b0;
    }

    /* Tabla estilo Pixelfed */
    .px-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .px-table thead th {
        background: rgba(0, 0, 0, 0.3);
        color: #a0a0b0;
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .px-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .px-table tbody tr:hover {
        background: rgba(0, 149, 246, 0.05);
    }

    .px-table tbody td {
        padding: 1rem;
        color: #e0e0e0;
        vertical-align: middle;
    }

    /* Badges */
    .badge-completed {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
        padding: 0.3rem 0.75rem;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    /* Avatar en tabla */
    .avatar-sm {
        width: 32px;
        height: 32px;
        background: rgba(0, 149, 246, 0.15);
        border-radius: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        color: #0095f6;
    }

    /* Lista de sucursales */
    .branch-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .branch-item:last-child {
        border-bottom: none;
    }

    .branch-name {
        font-weight: 600;
        color: white;
        font-size: 0.9rem;
    }

    .branch-total {
        font-weight: 800;
        color: #0095f6;
        font-size: 1.1rem;
    }

    /* Alertas */
    .alert-pixelfed {
        background: rgba(0, 149, 246, 0.1);
        border: 1px solid rgba(0, 149, 246, 0.2);
        border-radius: 16px;
        color: #0095f6;
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

    /* Filtros */
    .form-control-pixelfed, .form-select-pixelfed {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 0.6rem 1rem;
        color: white;
        font-size: 0.85rem;
    }

    .form-control-pixelfed:focus, .form-select-pixelfed:focus {
        border-color: #0095f6;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 149, 246, 0.2);
    }

    .btn-primary-pixelfed {
        background: linear-gradient(135deg, #0095f6, #00c3ff);
        border: none;
        border-radius: 40px;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-primary-pixelfed:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 149, 246, 0.4);
    }

    /* Badge sucursal */
    .badge-sucursal {
        background: rgba(0, 149, 246, 0.15);
        color: #0095f6;
        padding: 0.3rem 0.75rem;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .px-table thead {
            display: none;
        }
        .px-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border-radius: 16px;
            background: rgba(15, 25, 45, 0.4);
        }
        .px-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .px-table tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #0095f6;
            font-size: 0.7rem;
            text-transform: uppercase;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-pixelfed">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2 me-1"></i>Dashboard</a></li>
            <li class="breadcrumb-item active">Administración</li>
        </ol>
    </nav>

    <!-- Encabezado -->
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0 text-white">
                <i class="bi bi-bar-chart-steps me-2" style="color: #0095f6;"></i>
                Centro de Administración
            </h4>
            <p class="text-secondary small mb-0">Monitoreo de sucursales y rendimiento global</p>
        </div>
        <span class="badge bg-primary bg-opacity-15 text-primary px-3 py-2 rounded-pill">
            <i class="bi bi-calendar3 me-1"></i>{{ now()->format('d M, Y') }}
        </span>
    </div>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="alert alert-pixelfed mb-4">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- ============================================ -->
    <!-- FILTROS DE FECHA                             -->
    <!-- ============================================ -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="px-card p-3">
                <form method="GET" action="{{ route('dashboard') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label text-white small fw-bold">Desde</label>
                        <input type="date" name="fecha_inicio" class="form-control form-control-pixelfed" 
                               value="{{ $fechaInicio ?? now()->startOfMonth()->toDateString() }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-white small fw-bold">Hasta</label>
                        <input type="date" name="fecha_fin" class="form-control form-control-pixelfed" 
                               value="{{ $fechaFin ?? now()->toDateString() }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-white small fw-bold">Rápido</label>
                        <select name="rango" class="form-select form-select-pixelfed">
                            <option value="dia" {{ ($rango ?? 'mes') == 'dia' ? 'selected' : '' }}>Hoy</option>
                            <option value="semana" {{ ($rango ?? 'mes') == 'semana' ? 'selected' : '' }}>Esta semana</option>
                            <option value="mes" {{ ($rango ?? 'mes') == 'mes' ? 'selected' : '' }}>Este mes</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary-pixelfed w-100">
                            <i class="bi bi-search me-2"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Fila 1: KPIs Rápidos -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-3">
            <div class="px-card p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="kpi-icon">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div>
                        <div class="kpi-value">${{ number_format($totalVentas, 0, ',', '.') }}</div>
                        <div class="kpi-label">Ingresos Totales</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="px-card p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="kpi-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <div class="kpi-value">{{ $totalProductos }}</div>
                        <div class="kpi-label">Productos</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="px-card p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="kpi-icon">
                        <i class="bi bi-gpu-card"></i>
                    </div>
                    <div>
                        <div class="kpi-value">{{ $conteoGpus }}</div>
                        <div class="kpi-label">GPUs en Stock</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="px-card p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="kpi-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div>
                        <div class="kpi-value">{{ $totalUsuarios }}</div>
                        <div class="kpi-label">Usuarios</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fila 2: Gráfico y Resumen de Inventario -->
    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="px-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-white">
                        <i class="bi bi-graph-up me-2" style="color: #0095f6;"></i>
                        Rendimiento por Sede
                    </h5>
                </div>
                <div style="position: relative; height: 320px; width: 100%;">
                    <canvas id="ventasChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="px-card p-4">
                <h5 class="fw-bold mb-4 text-white">
                    <i class="bi bi-building me-2" style="color: #0095f6;"></i>
                    Ventas por Sucursal
                </h5>
                <div>
                    @foreach($ventasPorSucursal as $sede)
                        <div class="branch-item">
                            <div>
                                <div class="branch-name">{{ $sede->sucursal }}</div>
                                <small class="text-secondary">Sede Operativa</small>
                            </div>
                            <div class="branch-total">${{ number_format($sede->total, 0, ',', '.') }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4 pt-3 border-top" style="border-color: rgba(255,255,255,0.05);">
                    <p class="small text-secondary mb-0">
                        <i class="bi bi-info-circle me-1"></i>
                        El administrador puede visualizar el flujo de caja en tiempo real por cada punto de venta registrado.
                    </p>
                </div>
            </div>
        </div>
    </div>
        <!-- Fila 3: Ranking de Vendedores y Mejores Clientes -->
    <div class="row g-4 mb-4">
        <!-- Ranking de Vendedores -->
        <div class="col-md-6">
            <div class="px-card p-4">
                <h5 class="fw-bold mb-3 text-white">
                    <i class="bi bi-trophy-fill me-2" style="color: #ffc107;"></i>
                    Top Vendedores
                </h5>
                <div class="table-responsive">
                    <table class="px-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Vendedor</th>
                                <th>Sucursal</th>
                                <th class="text-end">Ventas</th>
                                <th class="text-end">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topVendedores as $index => $vendedor)
                            <tr>
                                <td>
                                    @if($index == 0)
                                        <i class="bi bi-trophy-fill fs-5" style="color: #ffc107;" title="1° lugar"></i>
                                    @elseif($index == 1)
                                        <i class="bi bi-trophy-fill fs-5 text-secondary" title="2° lugar"></i>
                                    @elseif($index == 2)
                                        <i class="bi bi-trophy-fill fs-5" style="color: #cd7f32;" title="3° lugar"></i>
                                    @else
                                        <span class="text-muted">#{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-white">{{ $vendedor->name }}</span>
                                </td>
                                <td>
                                    <span class="badge-sucursal">
                                        {{ $vendedor->sucursal_id ? \App\Models\Branch::find($vendedor->sucursal_id)->name ?? 'N/A' : 'Sin sucursal' }}
                                    </span>
                                </td>
                                <td class="text-end">{{ $vendedor->cantidad_ventas }}</td>
                                <td class="text-end fw-bold" style="color: #0095f6;">
                                    ${{ number_format($vendedor->total_vendido, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-3 text-muted">
                                    No hay ventas de vendedores en este período
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Mejores Clientes -->
        <div class="col-md-6">
            <div class="px-card p-4">
                <h5 class="fw-bold mb-3 text-white">
                    <i class="bi bi-stars me-2" style="color: #0095f6;"></i>
                    Mejores Clientes
                </h5>
                <div class="table-responsive">
                    <table class="px-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Cliente</th>
                                <th class="text-center">Compras</th>
                                <th class="text-end">Total Gastado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mejoresClientes as $index => $cliente)
                            <tr>
                                <td>
                                    @if($index == 0)
                                        <i class="bi bi-trophy-fill fs-5" style="color: #ffc107;" title="1° lugar"></i>
                                    @elseif($index == 1)
                                        <i class="bi bi-trophy-fill fs-5 text-secondary" title="2° lugar"></i>
                                    @elseif($index == 2)
                                        <i class="bi bi-trophy-fill fs-5" style="color: #cd7f32;" title="3° lugar"></i>
                                    @else
                                        <span class="text-muted">#{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div>
                                        <span class="fw-bold text-white">{{ $cliente->name }}</span>
                                        <br>
                                        <small class="text-secondary">{{ $cliente->email }}</small>
                                    </div>
                                </td>
                                <td class="text-center">{{ $cliente->cantidad_compras }}</td>
                                <td class="text-end fw-bold" style="color: #0095f6;">
                                    ${{ number_format($cliente->total_gastado, 0, ',', '.') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-3 text-muted">
                                    No hay clientes con compras en este período
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Fila 3: Tabla de Ventas Recientes -->
    <div class="row">
        <div class="col-12">
            <div class="px-card">
                <div class="p-4 border-bottom" style="border-color: rgba(255,255,255,0.05);">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <h5 class="fw-bold mb-0 text-white">
                            <i class="bi bi-receipt me-2" style="color: #0095f6;"></i>
                            Centro de Ventas y Vendedores
                        </h5>
                        <a href="{{ route('reporte.ventas') }}" 
   class="btn btn-sm btn-outline-pixelfed" target="_blank">
    <i class="bi bi-file-pdf me-1"></i> Reporte de Ventas
</a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="px-table">
                        <thead>
                            <tr>
                                <th>Venta ID</th>
                                <th>Responsable</th>
                                <th>Sucursal</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th class="text-end">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($ventasRecientes as $venta)
                            <tr>
                                <td data-label="ID">
                                    <span class="fw-bold text-white">#{{ $venta->id }}</span>
                                </td>
                                <td data-label="Responsable">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm">
                                            {{ substr($venta->usuario->name, 0, 2) }}
                                        </div>
                                        <span>{{ $venta->usuario->name }}</span>
                                    </div>
                                </td>
                                <td data-label="Sucursal">
                                    <span class="badge-sucursal">
                                        <i class="bi bi-building me-1"></i>
                                        {{ $venta->sucursal->name ?? 'Sucursal no asignada' }}
                                    </span>
                                </td>
                                <td data-label="Fecha">
                                    <span class="small">{{ $venta->created_at->format('d/m/Y H:i') }}</span>
                                </td>
                                <td data-label="Total">
                                    <span class="fw-bold" style="color: #0095f6;">${{ number_format($venta->total, 0, ',', '.') }}</span>
                                </td>
                                <td data-label="Estado" class="text-end">
                                    <span class="badge-completed">
                                        <i class="bi bi-check-circle me-1"></i>COMPLETADO
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">No hay ventas en el período seleccionado</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para Gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('ventasChart').getContext('2d');
        
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($ventasPorSucursal->pluck('sucursal')) !!},
                datasets: [{
                    label: 'Ventas ($)',
                    data: {!! json_encode($ventasPorSucursal->pluck('total')) !!},
                    backgroundColor: '#0095f6',
                    borderRadius: 8,
                    barPercentage: 0.65,
                    categoryPercentage: 0.8,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(15, 25, 45, 0.95)',
                        titleColor: '#fff',
                        bodyColor: '#a0a0b0',
                        borderColor: '#0095f6',
                        borderWidth: 1,
                        callbacks: {
                            label: function(context) {
                                return '$ ' + context.raw.toLocaleString('es-CL');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255, 255, 255, 0.05)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#a0a0b0',
                            font: { size: 11 },
                            callback: function(value) {
                                return '$' + value.toLocaleString('es-CL');
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            color: '#a0a0b0',
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    });
</script>

<style>
    /* Botón outline estilo Pixelfed */
    .btn-outline-pixelfed {
        background: transparent;
        border: 1px solid rgba(0, 149, 246, 0.5);
        color: #0095f6;
        border-radius: 40px;
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
</style>
@endsection