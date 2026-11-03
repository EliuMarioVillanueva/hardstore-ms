
@extends('layouts.app')

@section('content')
<style>
    .gacha-container {
        background: rgba(15, 25, 45, 0.8);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 193, 7, 0.3);
        border-radius: 2rem;
        padding: 2rem;
        text-align: center;
        max-width: 500px;
        margin: 0 auto;
    }

    .gacha-machine {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.2), rgba(255, 152, 0, 0.1));
        border: 2px solid rgba(255, 193, 7, 0.5);
        border-radius: 1.5rem;
        padding: 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .gacha-machine::before {
        content: '🎰';
        font-size: 5rem;
        display: block;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .gacha-btn {
        background: linear-gradient(135deg, #ffc107, #ff9800);
        border: none;
        border-radius: 3rem;
        padding: 1rem 3rem;
        font-size: 1.2rem;
        font-weight: 800;
        color: white;
        transition: all 0.3s;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    .gacha-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 0 30px rgba(255, 193, 7, 0.5);
    }

    .gacha-btn:disabled {
        opacity: 0.5;
        animation: none;
        cursor: not-allowed;
    }

    .premio-card {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 1rem;
        padding: 1rem;
        margin-bottom: 0.5rem;
    }

    .puntos-display {
        font-size: 3rem;
        font-weight: 800;
        color: #ffc107;
    }

    .barra-gacha {
        background: rgba(0, 0, 0, 0.3);
        border-radius: 2rem;
        height: 2rem;
        overflow: hidden;
        margin: 1rem 0;
    }

    .barra-gacha-lleno {
        background: linear-gradient(90deg, #ffc107, #ff9800);
        height: 100%;
        border-radius: 2rem;
        transition: width 0.5s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        color: white;
    }
</style>

<div class="container py-5">
    <div class="gacha-container">
        <!-- Título -->
        <h1 class="fw-bold text-white mb-2">
            <i class="bi bi-dice-5 me-2" style="color: #ffc107;"></i>
            Gacha de Descuentos
        </h1>
        <p class="text-secondary mb-4">¡Gasta 100 puntos y gana un descuento!</p>

        <!-- Puntos actuales -->
        <div class="mb-4">
            <div class="puntos-display">{{ $puntos->cantidad }}</div>
            <div class="text-secondary small">Puntos disponibles</div>
            <div class="barra-gacha">
                @php $porcentaje = min(100, ($puntos->cantidad / 100) * 100); @endphp
                <div class="barra-gacha-lleno" style="width: {{ $porcentaje }}%;">
                    {{ $puntos->cantidad }}/100
                </div>
            </div>
        </div>

        <!-- Máquina gacha -->
        <div class="gacha-machine">
            @if($puntos->cantidad >= 100)
                <form action="{{ route('cliente.gacha.tirar') }}" method="POST">
                    @csrf
                    <button type="submit" class="gacha-btn">
                        <i class="bi bi-dice-5 me-2"></i>¡TIRAR!
                    </button>
                </form>
            @else
                <button class="gacha-btn" disabled>
                    <i class="bi bi-lock me-2"></i>Necesitas 100 puntos
                </button>
            @endif
        </div>

        <!-- Premios posibles -->
        <h5 class="text-white mb-3">Premios posibles:</h5>
        <div class="row g-2">
            <div class="col-6">
                <div class="premio-card">
                    <i class="bi bi-percent fs-4" style="color: #0095f6;"></i>
                    <span class="text-white ms-2">5% descuento</span>
                </div>
            </div>
            <div class="col-6">
                <div class="premio-card">
                    <i class="bi bi-percent fs-4" style="color: #0095f6;"></i>
                    <span class="text-white ms-2">10% descuento</span>
                </div>
            </div>
            <div class="col-6">
                <div class="premio-card">
                    <i class="bi bi-percent fs-4" style="color: #0095f6;"></i>
                    <span class="text-white ms-2">15% descuento</span>
                </div>
            </div>
            <div class="col-6">
                <div class="premio-card">
                    <i class="bi bi-truck fs-4" style="color: #28a745;"></i>
                    <span class="text-white ms-2">Envío gratis</span>
                </div>
            </div>
        </div>

        <!-- Volver -->
        <a href="{{ route('cliente.panel') }}" class="btn btn-outline-pixelfed mt-4 w-100">
            <i class="bi bi-arrow-left me-2"></i>Volver a Mi Panel
        </a>
    </div>
</div>
@endsection