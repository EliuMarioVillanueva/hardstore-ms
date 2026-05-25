@extends('layouts.app')

@section('content')
<style>
    /* Estilos registro estilo Pixelfed */
    .auth-container {
        min-height: 80vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
    }

    .auth-card {
        background: rgba(15, 25, 45, 0.6);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 28px;
        padding: 2rem;
        width: 100%;
        max-width: 480px;
        transition: all 0.3s ease;
    }

    .auth-card:hover {
        border-color: rgba(0, 149, 246, 0.3);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .auth-logo {
        background: linear-gradient(135deg, #0095f6, #00c3ff);
        width: 64px;
        height: 64px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
    }

    .auth-logo i {
        font-size: 2rem;
        color: white;
    }

    .auth-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 0.25rem;
    }

    .auth-subtitle {
        font-size: 0.85rem;
        color: #a0a0b0;
    }

    /* Campos de formulario */
    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-label-pixelfed {
        display: block;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #a0a0b0;
        margin-bottom: 0.5rem;
    }

    .form-input-pixelfed {
        width: 100%;
        background: rgba(0, 0, 0, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 0.85rem 1rem;
        color: white;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .form-input-pixelfed:focus {
        border-color: #0095f6;
        outline: none;
        box-shadow: 0 0 0 3px rgba(0, 149, 246, 0.2);
        background: rgba(0, 0, 0, 0.5);
    }

    .form-input-pixelfed::placeholder {
        color: #6c757d;
    }

    /* Botón */
    .btn-auth {
        width: 100%;
        background: linear-gradient(135deg, #0095f6, #00c3ff);
        border: none;
        border-radius: 40px;
        padding: 0.85rem;
        font-weight: 700;
        font-size: 1rem;
        color: white;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-auth:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 149, 246, 0.4);
    }

    /* Enlaces */
    .auth-links {
        display: flex;
        justify-content: flex-end;
        margin-top: 1.5rem;
    }

    .auth-links a {
        color: #0095f6;
        text-decoration: none;
        font-size: 0.85rem;
        transition: opacity 0.2s;
    }

    .auth-links a:hover {
        opacity: 0.8;
    }

    .login-link {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .login-link p {
        color: #a0a0b0;
        font-size: 0.85rem;
    }

    .login-link a {
        color: #0095f6;
        text-decoration: none;
        font-weight: 600;
    }

    /* Alertas */
    .alert-error {
        background: rgba(220, 53, 69, 0.1);
        border: 1px solid rgba(220, 53, 69, 0.2);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        color: #dc3545;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.7rem;
        margin-top: 0.5rem;
        display: block;
    }
</style>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">
                <i class="bi bi-person-plus"></i>
            </div>
            <h1 class="auth-title">Crear Cuenta</h1>
            <p class="auth-subtitle">Regístrate para comenzar a comprar</p>
        </div>

        <!-- Errores de validación generales -->
        @if($errors->any())
            <div class="alert-error">
                <i class="bi bi-exclamation-triangle-fill"></i>
                Por favor corrige los errores del formulario
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nombre -->
            <div class="form-group">
                <label for="name" class="form-label-pixelfed">
                    <i class="bi bi-person me-1"></i>Nombre Completo
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    class="form-input-pixelfed" 
                    value="{{ old('name') }}" 
                    placeholder="Juan Pérez"
                    required 
                    autofocus>
                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Correo Electrónico -->
            <div class="form-group">
                <label for="email" class="form-label-pixelfed">
                    <i class="bi bi-envelope me-1"></i>Correo Electrónico
                </label>
                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    class="form-input-pixelfed" 
                    value="{{ old('email') }}" 
                    placeholder="usuario@ejemplo.com"
                    required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <label for="password" class="form-label-pixelfed">
                    <i class="bi bi-lock me-1"></i>Contraseña
                </label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    class="form-input-pixelfed" 
                    placeholder="••••••••"
                    required>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label-pixelfed">
                    <i class="bi bi-lock-fill me-1"></i>Confirmar Contraseña
                </label>
                <input 
                    type="password" 
                    id="password_confirmation" 
                    name="password_confirmation" 
                    class="form-input-pixelfed" 
                    placeholder="••••••••"
                    required>
                @error('password_confirmation')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <!-- Botón de registro -->
            <button type="submit" class="btn-auth mt-2">
                <i class="bi bi-check-circle me-2"></i>Registrarme
            </button>

            <!-- Enlace a login -->
            <div class="login-link">
                <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
            </div>
        </form>
    </div>
</div>
@endsection