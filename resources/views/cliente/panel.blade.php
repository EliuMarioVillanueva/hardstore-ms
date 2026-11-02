@extends('layouts.app')

@section('content')
<style>
    .cliente-card {
        background: rgba(15, 25, 45, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.5rem;
        overflow: hidden;
        height: 100%;
    }

    .cliente-header {
        background: linear-gradient(135deg, rgba(0, 149, 246, 0.15), rgba(0, 195, 255, 0.05));
        padding: 1.5rem;
        text-align: center;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .cliente-avatar {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #0095f6, #00c3ff);
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }

    .cliente-avatar i {
        font-size: 2.5rem;
        color: white;
    }

    .stat-card-cliente {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 1rem;
        padding: 1rem;
        text-align: center;
    }

    .stat-number-cliente {
        font-size: 1.5rem;
        font-weight: 800;
        color: #0095f6;
    }

    .barra-progreso {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 2rem;
        height: 1.5rem;
        overflow: hidden;
        margin: 0.5rem 0;
    }

    .barra-progreso-lleno {
        background: linear-gradient(90deg, #0095f6, #00c3ff);
        height: 100%;
        border-radius: 2rem;
        transition: width 0.5s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.7rem;
        font-weight: 700;
        color: white;
    }

    .btn-gacha {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        border: none;
        border-radius: 2rem;
        padding: 0.6rem 1.2rem;
        font-weight: 700;
        color: white;
        transition: all 0.2s;
    }

    .btn-gacha:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
        color: white;
    }

    .badge-descuento {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
        padding: 0.3rem 0.75rem;
        border-radius: 2rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .favorito-item {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 0.75rem;
        padding: 0.6rem 0.8rem;
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .compra-item {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 0.75rem;
        padding: 0.6rem 0.8rem;
        margin-bottom: 0.5rem;
    }

    .table-scroll {
        max-height: 400px;
        overflow-y: auto;
    }

    .table-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .table-scroll::-webkit-scrollbar-thumb {
        background: #0095f6;
        border-radius: 4px;
    }

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
</style>

<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="background: rgba(15, 25, 45, 0.4); padding: 0.6rem 1rem; border-radius: 0.75rem;">
            <li class="breadcrumb-item"><a href="{{ route('welcome') }}" style="color: #0095f6;">Inicio</a></li>
            <li class="breadcrumb-item active">Mi Panel</li>
        </ol>
    </nav>

    @if(session('success'))
        <div class="alert alert-success bg-success bg-opacity-25 text-success border-0 rounded-3 mb-4">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger bg-danger bg-opacity-25 text-danger border-0 rounded-3 mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="row g-4">
        <!-- Columna izquierda: Info del cliente -->
        <div class="col-md-4">
            <div class="cliente-card">
                <div class="cliente-header">
                    <div class="cliente-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <h4 class="text-white mb-1">{{ $user->name }}</h4>
                    <p class="text-secondary small mb-0">{{ $user->email }}</p>
                    <span class="badge bg-primary bg-opacity-25 text-primary mt-2">
                        <i class="bi bi-person me-1"></i>Cliente
                    </span>
                </div>
                <div class="p-4">
                    <!-- Puntos -->
                    <div class="stat-card-cliente mb-3">
                        <div class="stat-number-cliente">{{ $puntos->cantidad }}</div>
                        <div class="small text-secondary">Puntos disponibles</div>
                        <div class="barra-progreso mt-2">
                            @php $porcentaje = min(100, ($puntos->cantidad / 100) * 100); @endphp
                            <div class="barra-progreso-lleno" style="width: {{ $porcentaje }}%;">
                                @if($porcentaje >= 20) {{ round($porcentaje) }}% @endif
                            </div>
                        </div>
                        <small class="text-secondary">{{ $puntos->cantidad }}/100 puntos para gacha</small>
                    </div>

                    <!-- Botón gacha -->
                    @if($puntos->cantidad >= 100)
                        <a href="{{ route('cliente.gacha') }}" class="btn btn-gacha w-100 mb-3">
                            <i class="bi bi-dice-5 me-2"></i>¡Tirar Gacha!
                        </a>
                    @else
                        <button class="btn btn-gacha w-100 mb-3" disabled style="opacity: 0.5;">
                            <i class="bi bi-dice-5 me-2"></i>Gacha ({{ $puntos->cantidad }}/100)
                        </button>
                    @endif

                    <!-- Descuentos activos -->
                    <h6 class="text-white mb-2">
                        <i class="bi bi-ticket-perforated me-2 text-primary"></i>Mis descuentos
                    </h6>
                    @if($descuentos->count() > 0)
                        @foreach($descuentos as $descuento)
                            <div class="favorito-item">
                                <span class="text-white small">{{ $descuento->descripcion }}</span>
                                <span class="badge-descuento">Activo</span>
                            </div>
                        @endforeach
                    @else
                        <p class="text-secondary small">No tienes descuentos aún.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Columna derecha: Pestañas -->
        <div class="col-md-8">
            <div class="cliente-card">
                <ul class="nav nav-tabs-custom" id="clienteTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="compras-tab" data-bs-toggle="tab" data-bs-target="#compras" type="button" role="tab">
                            <i class="bi bi-receipt me-2"></i>Mis Compras
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="favoritos-tab" data-bs-toggle="tab" data-bs-target="#favoritos" type="button" role="tab">
                            <i class="bi bi-heart me-2"></i>Favoritos
                        </button>
                    </li>
                </ul>

                <div class="tab-content p-3">
                    <!-- Pestaña Compras -->
                    <div class="tab-pane fade show active" id="compras" role="tabpanel">
                        <div class="table-scroll">
                            @if($compras->count() > 0)
                                @foreach($compras as $compra)
                                    <div class="compra-item">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <span class="badge {{ $compra->estado === 'completado' ? 'bg-success bg-opacity-25 text-success' : 'bg-warning bg-opacity-25 text-warning' }}">
                                                <i class="bi {{ $compra->estado === 'completado' ? 'bi-check-circle' : 'bi-clock' }} me-1"></i>
                                                {{ ucfirst($compra->estado) }}
                                            </span>
                                            <small class="text-secondary">#{{ $compra->id }} - {{ $compra->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                        <p class="text-white mb-1">{{ $compra->detalles->first()->producto->name }}</p>
                                        <p class="text-secondary small mb-0">Sucursal: {{ $compra->sucursal->name }}</p>
                                        <p class="fw-bold mb-0" style="color: #0095f6;">${{ number_format($compra->total, 0, ',', '.') }}</p>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No has realizado compras aún.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Pestaña Favoritos -->
                    <div class="tab-pane fade" id="favoritos" role="tabpanel">
                        <div class="table-scroll">
                            @if($favoritos->count() > 0)
                                @foreach($favoritos as $favorito)
                                    <div class="favorito-item">
                                        <div>
                                            <span class="text-white small">{{ $favorito->producto->name }}</span>
                                            <br>
                                            <small class="text-secondary">{{ $favorito->producto->sku }}</small>
                                        </div>
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="fw-bold" style="color: #0095f6;">${{ number_format($favorito->producto->precio_venta, 0, ',', '.') }}</span>
                                            <form action="{{ route('cliente.favoritos.toggle', $favorito->producto_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm" style="color: #dc3545;">
                                                    <i class="bi bi-heart-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-heart fs-1 text-muted"></i>
                                    <p class="text-muted mt-2">No tienes productos favoritos aún.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection