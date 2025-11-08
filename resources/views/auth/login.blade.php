@extends('layout')

@section('title', 'Iniciar Sesión')

@section('cabecera')
<div class="navbar-spacer" style="height: 80px;"></div>
@endsection

@section('contenido')
<style>
    
</style>

<div class="login-wrapper">
    <div class="login-box">
        <!-- Lado izquierdo con logo y texto -->
        <div class="login-left">
            <img src="{{ asset('images/logoFertirriego.png') }}" alt="Logo Fertirriego">
            <h2>Bienvenido a <br>Fertirriego</h2>
            <p>Optimiza el riego de tus cultivos con nuestro sistema automatizado.</p>
        </div>

        <!-- Lado derecho con formulario -->
        <div class="login-right">
            <h3>Iniciar Sesión</h3>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('status'))
                <div class="alert alert-info">{{ session('status') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p class="mb-1">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="login" class="form-label">Usuario o Email</label>
                    <input type="text" id="login" name="login"
                           class="form-control @error('login') is-invalid @enderror"
                           value="{{ old('login') }}" required autofocus
                           placeholder="Ingresa tu usuario o email">
                    @error('login')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password"
                           class="form-control" required
                           placeholder="Ingresa tu contraseña">
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" id="remember" name="remember" class="form-check-input">
                    <label class="form-check-label" for="remember">Recordar sesión</label>
                </div>

                <button type="submit" class="btn w-100" style="background-color: #64A500; border-color: #64A500; color: #fff;">
    <i class="fas fa-sign-in-alt me-2"></i> Ingresar
</button>

            </form>

            <div class="text-center mt-3">
                <p class="mb-1">¿No tienes cuenta?</p>
                <a href="{{ route('register') }}" class="btn btn-outline-success">
                    <i class="fas fa-user-plus me-2"></i> Regístrate aquí
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
