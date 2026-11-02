@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="px-card p-4 text-center" style="background: rgba(15, 25, 45, 0.8); border: 1px solid rgba(0, 149, 246, 0.3); border-radius: 1.5rem;">
                
                <!-- Icono de éxito -->
                <div class="bg-success bg-opacity-25 rounded-circle d-inline-flex p-3 mb-3">
                    <i class="bi bi-check-circle text-success display-4"></i>
                </div>
                
                <h3 class="fw-bold text-white mb-2">¡Compra registrada!</h3>
                <p class="text-secondary mb-4">Realiza la transferencia para confirmar tu pedido</p>

                <!-- QR -->
                <div class="bg-white p-3 rounded-3 d-inline-block mb-4">
                    {!! QrCode::size(250)->generate(
                        "Monto: $" . number_format($venta->total, 2, ',', '.') . "\n" .
                        "Cuenta: 1234-5678-9012-3456\n" .
                        "Local: " . $venta->sucursal->name . "\n" .
                        "Artículo: " . $venta->detalles->first()->producto->name . "\n" .
                        "Venta: #" . $venta->id
                    ) !!}
                </div>

                <!-- Detalles -->
                <div class="text-start bg-dark bg-opacity-50 p-3 rounded-3 mb-4">
                    <p class="text-white mb-1"><strong>Monto:</strong> ${{ number_format($venta->total, 2, ',', '.') }}</p>
                    <p class="text-white mb-1"><strong>Cuenta:</strong> 1234-5678-9012-3456</p>
                    <p class="text-white mb-1"><strong>Local:</strong> {{ $venta->sucursal->name }}</p>
                    <p class="text-white mb-0"><strong>Artículo:</strong> {{ $venta->detalles->first()->producto->name }}</p>
                </div>

                <!-- Botones -->
                <div class="d-flex gap-2">
                    <a href="{{ route('productos.index') }}" class="btn w-50" style="background: rgba(0, 149, 246, 0.15); border: 1px solid rgba(0, 149, 246, 0.4); color: #0095f6; border-radius: 2rem; padding: 0.6rem 1rem; font-weight: 500; transition: all 0.2s;">
                        <i class="bi bi-arrow-left me-2"></i>Volver
                    </a>
                    <a href="{{ route('productos.index') }}" class="btn w-50" style="background: linear-gradient(135deg, #0095f6, #00c3ff); border: none; color: white; border-radius: 2rem; padding: 0.6rem 1rem; font-weight: 600; transition: all 0.2s;">
                        <i class="bi bi-grid me-2"></i>Seguir comprando
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection