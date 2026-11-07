@extends('layouts.app')

@section('content')
<style>
    /* ============================================ */
    /* ESTILOS DEL DASHBOARD (Sólidos y Limpios)    */
    /* ============================================ */
    .dashboard-container {
        padding: 1.5rem;
        min-height: 100vh;
    }

    /* Tarjetas */
    .px-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-color);
        border-radius: 1rem;
        transition: border-color 0.2s;
    }

    .px-card:hover {
        border-color: var(--primary);
    }

    /* KPI Cards */
    .kpi-icon {
        width: 48px;
        height: 48px;
        background: rgba(99, 102, 241, 0.1);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: var(--primary);
    }

    .kpi-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--text-main);
        line-height: 1.2;
    }

    .kpi-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--text-muted);
    }

    /* Tabla */
    .px-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }

    .px-table thead th {
        background: var(--bg-base);
        color: var(--text-muted);
        font-weight: 600;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .px-table tbody tr {
        border-bottom: 1px solid var(--border-color);
    }

    .px-table tbody tr:hover {
        background: var(--bg-hover);
    }

    .px-table tbody td {
        padding: 1rem;
        color: var(--text-main);
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

    .avatar-sm {
        width: 32px;
        height: 32px;
        background: rgba(99, 102, 241, 0.15);
        border-radius: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--primary);
    }

    /* Lista de sucursales */
    .branch-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid var(--border-color);
    }

    .branch-item:last-child {
        border-bottom: none;
    }

    .branch-name {
        font-weight: 600;
        color: var(--text-main);
        font-size: 0.9rem;
    }

    .branch-total {
        font-weight: 800;
        color: var(--primary);
        font-size: 1.1rem;
    }

    /* Filtros */
    .form-control-pixelfed, .form-select-pixelfed {
        background: var(--bg-base);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 0.6rem 1rem;
        color: var(--text-main);
        font-size: 0.85rem;
    }

    .form-control-pixelfed:focus, .form-select-pixelfed:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 1px var(--primary);
        outline: none;
    }

    .btn-primary-pixelfed {
        background: var(--primary);
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 600;
        font-size: 0.85rem;
        color: white;
        transition: background 0.2s;
    }

    .btn-primary-pixelfed:hover {
        background: #4f46e5;
    }

    /* Badge sucursal */
    .badge-sucursal {
        background: rgba(99, 102, 241, 0.1);
        color: var(--primary);
        padding: 0.3rem 0.75rem;
        border-radius: 40px;
        font-size: 0.7rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Breadcrumb */
    .breadcrumb-pixelfed {
        background: var(--bg-surface);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid var(--border-color);
        margin-bottom: 1.5rem;
    }

    .breadcrumb-pixelfed .breadcrumb-item a {
        color: var(--primary);
        text-decoration: none;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .px-table thead {
            display: none;
        }
        .px-table tbody tr {
            display: block;
            margin-bottom: 1rem;
            border-radius: 8px;
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
        }
        .px-table tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-bottom: 1px solid var(--border-color);
        }
        .px-table tbody td:before {
            content: attr(data-label);
            font-weight: 600;
            color: var(--primary);
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
            <h4 class="fw-bold mb-0" style="color: var(--text-main);">
                <i class="bi bi-bar-chart-steps me-2" style="color: var(--primary);"></i>
                Centro de Administración
            </h4>
            <p class="small mb-0" style="color: var(--text-muted);">Monitoreo de sucursales y rendimiento global</p>
        </div>
        <span class="badge" style="background: var(--bg-surface); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.5rem 1rem; border-radius: 40px;">
            <i class="bi bi-calendar3 me-1"></i>{{ now()->format('d M, Y') }}
        </span>
    </div>

    <!-- Mensaje de éxito -->
    @if(session('success'))
        <div class="alert mb-4" style="background: rgba(40, 167, 69, 0.1); border: 1px solid rgba(40, 167, 69, 0.2); color: #28a745; border-radius: 8px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Filtros de Fecha -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="px-card p-3">
                <form method="GET" action="{{ route('dashboard') }}" class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold" style="color: var(--text-muted);">Desde</label>
                        <input type="date" name="fecha_inicio" class="form-control form-control-pixelfed" 
                               value="{{ $fechaInicio ?? now()->startOfMonth()->toDateString() }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold" style="color: var(--text-muted);">Hasta</label>
                        <input type="date" name="fecha_fin" class="form-control form-control-pixelfed" 
                               value="{{ $fechaFin ?? now()->toDateString() }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold" style="color: var(--text-muted);">Rápido</label>
                        <select name="rango" class="form-select form-select-pixelfed">
                            <option value="dia" {{ ($rango ?? 'mes') == 'dia' ? 'selected' : '' }}>Hoy</option>
                            <option value="semana" {{ ($rango ?? 'mes') == 'semana' ? 'selected' : '' }}>Esta semana</option>
                            <option value="mes" {{ ($rango ?? 'mes') == 'mes' ? 'selected' : '' }}>Este mes</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn-primary-pixelfed w-100">
                            <i class="bi bi-search me-2"></i>Filtrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- KPIs -->
    <div class="row g-4 mb-4">
        <div class="col-6 col-md-3">
            <div class="px-card p-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="kpi-icon"><i class="bi bi-currency-dollar"></i></div>
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
                    <div class="kpi-icon"><i class="bi bi-box-seam"></i></div>
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
                    <div class="kpi-icon"><i class="bi bi-gpu-card"></i></div>
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
                    <div class="kpi-icon"><i class="bi bi-people"></i></div>
                    <div>
                        <div class="kpi-value">{{ $totalUsuarios }}</div>
                        <div class="kpi-label">Usuarios</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="px-card p-4 h-100">
                <h5 class="fw-bold mb-4" style="color: var(--text-main);">
                    <i class="bi bi-building me-2" style="color: var(--primary);"></i>Ventas por Sede
                </h5>
                <div style="position: relative; height: 250px; width: 100%;">
                    <canvas id="ventasChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="px-card p-4 h-100">
                <h5 class="fw-bold mb-4" style="color: var(--text-main);">
                    <i class="bi bi-graph-up-arrow me-2" style="color: var(--primary);"></i>Tendencia (Últimos 7 días)
                </h5>
                <div style="position: relative; height: 250px; width: 100%;">
                    <canvas id="tendenciaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="px-card p-4 h-100">
                <h5 class="fw-bold mb-3" style="color: var(--text-main);">
                    <i class="bi bi-trophy-fill me-2" style="color: #ffc107;"></i>Top Vendedores
                </h5>
                <div class="table-responsive">
                    <table class="px-table">
                        <thead>
                            <tr><th>#</th><th>Vendedor</th><th>Sucursal</th><th class="text-end">Ventas</th></tr>
                        </thead>
                        <tbody>
                            @forelse($topVendedores as $index => $vendedor)
                            <tr>
                                <td>
                                    @if($index == 0) <i class="bi bi-trophy-fill" style="color: #ffc107;"></i>
                                    @elseif($index == 1) <i class="bi bi-trophy-fill" style="color: #c0c0c0;"></i>
                                    @elseif($index == 2) <i class="bi bi-trophy-fill" style="color: #cd7f32;"></i>
                                    @else <span style="color: var(--text-muted);">#{{ $index + 1 }}</span> @endif
                                </td>
                                <td><span style="color: var(--text-main);">{{ $vendedor->name }}</span></td>
                                <td><span class="badge-sucursal">{{ $vendedor->sucursal_id ? \App\Models\Branch::find($vendedor->sucursal_id)->name ?? 'N/A' : 'N/A' }}</span></td>
                                <td class="text-end fw-bold" style="color: var(--primary);">${{ number_format($vendedor->total_vendido, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-3" style="color: var(--text-muted);">No hay ventas en este período</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="px-card p-4 h-100">
                <h5 class="fw-bold mb-3" style="color: var(--text-main);">
                    <i class="bi bi-stars me-2" style="color: var(--primary);"></i>Mejores Clientes
                </h5>
                <div class="table-responsive">
                    <table class="px-table">
                        <thead>
                            <tr><th>#</th><th>Cliente</th><th class="text-center">Compras</th><th class="text-end">Total</th></tr>
                        </thead>
                        <tbody>
                            @forelse($mejoresClientes as $index => $cliente)
                            <tr>
                                <td>
                                    @if($index == 0) <i class="bi bi-trophy-fill" style="color: #ffc107;"></i>
                                    @elseif($index == 1) <i class="bi bi-trophy-fill" style="color: #c0c0c0;"></i>
                                    @elseif($index == 2) <i class="bi bi-trophy-fill" style="color: #cd7f32;"></i>
                                    @else <span style="color: var(--text-muted);">#{{ $index + 1 }}</span> @endif
                                </td>
                                <td>
                                    <div style="color: var(--text-main);">{{ $cliente->name }}</div>
                                    <small style="color: var(--text-muted);">{{ $cliente->email }}</small>
                                </td>
                                <td class="text-center" style="color: var(--text-main);">{{ $cliente->cantidad_compras }}</td>
                                <td class="text-end fw-bold" style="color: var(--primary);">${{ number_format($cliente->total_gastado, 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-3" style="color: var(--text-muted);">No hay clientes con compras</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Ventas Recientes -->
    <div class="row">
        <div class="col-12">
            <div class="px-card">
                <div class="p-4 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-3" style="border-color: var(--border-color) !important;">
                    <h5 class="fw-bold mb-0" style="color: var(--text-main);">
                        <i class="bi bi-receipt me-2" style="color: var(--primary);"></i>Centro de Ventas
                    </h5>
                    <a href="{{ route('reporte.ventas') }}" class="btn-primary-pixelfed" target="_blank">
                        <i class="bi bi-file-pdf me-1"></i> Reporte PDF
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="px-table">
                        <thead>
                            <tr><th>Venta ID</th><th>Responsable</th><th>Sucursal</th><th>Fecha</th><th>Total</th><th class="text-end">Estado</th></tr>
                        </thead>
                        <tbody>
                            @forelse($ventasRecientes as $venta)
                            <tr>
                                <td data-label="ID"><span class="fw-bold" style="color: var(--text-main);">#{{ $venta->id }}</span></td>
                                <td data-label="Responsable">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-sm">{{ substr($venta->usuario->name, 0, 2) }}</div>
                                        <span style="color: var(--text-main);">{{ $venta->usuario->name }}</span>
                                    </div>
                                </td>
                                <td data-label="Sucursal"><span class="badge-sucursal"><i class="bi bi-building me-1"></i>{{ $venta->sucursal->name ?? 'N/A' }}</span></td>
                                <td data-label="Fecha"><span class="small" style="color: var(--text-muted);">{{ $venta->created_at->format('d/m/Y H:i') }}</span></td>
                                <td data-label="Total"><span class="fw-bold" style="color: var(--primary);">${{ number_format($venta->total, 0, ',', '.') }}</span></td>
                                <td data-label="Estado" class="text-end"><span class="badge-completed"><i class="bi bi-check-circle me-1"></i>COMPLETADO</span></td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="text-center py-5" style="color: var(--text-muted);">No hay ventas en el período seleccionado</td></tr>
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
        // Gráfico de Barras (Sucursales)
        const ctxVentas = document.getElementById('ventasChart').getContext('2d');
        new Chart(ctxVentas, {
            type: 'bar',
            data: {
                labels: {!! json_encode($ventasPorSucursal->pluck('sucursal')) !!},
                datasets: [{
                    data: {!! json_encode($ventasPorSucursal->pluck('total')) !!},
                    backgroundColor: '#6366f1',
                    borderRadius: 6,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#27272a' }, ticks: { color: '#a1a1aa' } },
                    x: { grid: { display: false }, ticks: { color: '#a1a1aa' } }
                }
            }
        });

        // Gráfico de Líneas (Tendencia)
        const ctxTendencia = document.getElementById('tendenciaChart').getContext('2d');
        let gradient = ctxTendencia.createLinearGradient(0, 0, 0, 250);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0)');

        new Chart(ctxTendencia, {
            type: 'line',
            data: {
                labels: {!! json_encode($fechasGrafico ?? []) !!},
                datasets: [{
                    data: {!! json_encode($totalesGrafico ?? []) !!},
                    borderColor: '#6366f1',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#6366f1',
                    pointBorderColor: '#121215',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#27272a' }, ticks: { color: '#a1a1aa' } },
                    x: { grid: { display: false }, ticks: { color: '#a1a1aa' } }
                }
            }
        });
    });
</script>
@endsection