@extends('layouts.app')

@section('content')
<style>
    .form-card {
        background: rgba(15, 25, 45, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 1.5rem;
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
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #a0a0b0;
        margin-bottom: 0.5rem;
    }

    .form-control-pixelfed {
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 0.75rem;
        padding: 0.75rem 1rem;
        color: white;
        width: 100%;
    }

    .form-control-pixelfed:focus {
        border-color: #0095f6;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0, 149, 246, 0.2);
    }

    .btn-pixelfed-primary {
        background: linear-gradient(135deg, #0095f6, #00c3ff);
        border: none;
        border-radius: 2rem;
        padding: 0.7rem 1.5rem;
        font-weight: 600;
        color: white;
    }

    .btn-pixelfed-secondary {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 2rem;
        padding: 0.7rem 1.5rem;
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
</style>

<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-pixelfed">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('perfil.vendedor') }}">Mi Perfil</a></li>
            <li class="breadcrumb-item active">Editar Perfil</li>
        </ol>
    </nav>

    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="form-card">
                <div class="form-card-header">
                    <h3 class="fw-bold mb-0 text-white">
                        <i class="bi bi-pencil-square me-2" style="color: #0095f6;"></i>
                        Editar Perfil
                    </h3>
                    <p class="text-secondary mb-0 mt-2 small">Actualiza tu información personal</p>
                </div>
                
                <div class="form-card-body">
                    <form action="{{ route('perfil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label-pixelfed">Nombre Completo</label>
                            <input type="text" name="name" id="name" class="form-control-pixelfed" 
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label-pixelfed">Correo Electrónico</label>
                            <input type="email" name="email" id="email" class="form-control-pixelfed" 
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label-pixelfed">Nueva Contraseña (opcional)</label>
                            <input type="password" name="password" id="password" class="form-control-pixelfed" 
                                   placeholder="Dejar en blanco para mantener actual">
                            @error('password')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label-pixelfed">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" 
                                   class="form-control-pixelfed" placeholder="Repite la nueva contraseña">
                        </div>

                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('perfil.vendedor') }}" class="btn btn-pixelfed-secondary">
                                <i class="bi bi-x-lg me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-pixelfed-primary">
                                <i class="bi bi-check-lg me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection