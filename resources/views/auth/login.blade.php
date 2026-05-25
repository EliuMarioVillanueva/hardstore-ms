@extends('layouts.app')

@section('content')
<style>
    /* Estilos login estilo Pixelfed */
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
        max-width: 440px;
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
        margin-bottom: 1.5rem;
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

    /* Checkbox personalizado */
    .checkbox-wrapper {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .checkbox-wrapper input {
        width: 18px;
        height: 18px;
        accent-color: #0095f6;
        cursor: pointer;
    }

    .checkbox-wrapper span {
        font-size: 0.85rem;
        color: #a0a0b0;
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
        justify-content: space-between;
        align-items: center;
        margin-top: 1.5rem;
        font-size: 0.85rem;
    }

    .auth-links a {
        color: #0095f6;
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .auth-links a:hover {
        opacity: 0.8;
    }

    .register-link {
        text-align: center;
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .register-link p {
        color: #a0a0b0;
        font-size: 0.85rem;
    }

    .register-link a {
        color: #0095f6;
        text-decoration: none;
        font-weight: 600;
    }

    /* Alertas */
    .alert-pixelfed {
        background: rgba(0, 149, 246, 0.1);
        border: 1px solid rgba(0, 149, 246, 0.2);
        border-radius: 12px;
        padding: 0.75rem 1rem;
        margin-bottom: 1.5rem;
        color: #0095f6;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .alert-error {
        background: rgba(220, 53, 69, 0.1);
        border-color: rgba(220, 53, 69, 0.2);
        color: #dc3545;
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
                <i class="bi bi-box-seam"></i>
            </div>
            <h1 class="auth-title">HardStore MS</h1>
            <p class="auth-subtitle">Inicia sesión en tu cuenta</p>
        </div>

        <!-- Session Status (éxito al cerrar sesión, etc.) -->
        @if(session('status'))
            <div class="alert-pixelfed">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('status') }}
            </div>
        @endif

        <!-- Errores de validación generales -->
        @if($errors->any())
            <div class="alert-pixelfed alert-error">
                <i class="bi bi-exclamation-triangle-fill"></i>
                @foreach($errors->all() as $error)
                    {{ $error }}
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

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
                    required 
                    autofocus>
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

            <!-- Recordarme y Olvidé mi contraseña -->
            <div class="auth-links">
                <label class="checkbox-wrapper">
                    <input type="checkbox" name="remember" id="remember_me">
                    <span>Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}">
                        <i class="bi bi-key me-1"></i>¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <!-- Botón de inicio de sesión -->
            <button type="submit" class="btn-auth mt-4">
                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
            </button>

            <!-- Enlace a registro -->
            <div class="register-link">
                <p>¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
            </div>
        </form>
    </div>
</div>
@endsection