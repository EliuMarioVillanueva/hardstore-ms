@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold text-white mb-4">
        <i class="bi bi-clock-history me-2" style="color: #ffc107;"></i>
        Ventas Pendientes
    </h2>

    @if($ventasPendientes->count() > 0)
        <div class="row g-3">
            @foreach($ventasPendientes as $venta)
                <div class="col-md-6 col-lg-4">
                    <div class="px-card p-3" style="border-color: rgba(255, 193, 7, 0.3);">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-warning bg-opacity-25 text-warning">
                                <i class="bi bi-clock"></i> Pendiente
                            </span>
                            <small class="text-secondary">#{{ $venta->id }}</small>
                        </div>
                        <h6 class="text-white">{{ $venta->detalles->first()->producto->name }}</h6>
                        <p class="text-secondary small mb-1">Cliente: {{ $venta->usuario->name }}</p>
                        <p class="text-secondary small mb-1">Monto: ${{ number_format($venta->total, 0, ',', '.') }}</p>
                        <p class="text-secondary small mb-3">Fecha: {{ $venta->created_at->format('d/m/Y H:i') }}</p>
                        <form action="{{ route('ventas.confirmar', $venta->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-pixelfed-primary w-100">
                                <i class="bi bi-check-circle me-2"></i>Confirmar Pago
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-inbox fs-1 text-muted"></i>
            <p class="text-muted mt-2">No hay ventas pendientes.</p>
        </div>
    @endif
</div>
@endsection