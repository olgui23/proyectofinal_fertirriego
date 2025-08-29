@extends('layout')

@section('title', 'Iniciar Sesión')

@section('cabecera')

    <div class="navbar-spacer" style="height: 80px;"></div>

@endsection

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 text-center">Iniciar Sesión</h5>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif                    

                    @if(session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-1">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if ($errors->has('email_verification'))
                        <div class="alert alert-warning">
                            {!! $errors->first('email_verification') !!}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Campo Usuario/Email -->
                        <div class="mb-3">
                            <label for="login" class="form-label">Usuario o Email</label>
                            <input type="text" class="form-control @error('login') is-invalid @enderror" 
                                id="login" name="login" value="{{ old('login') }}"
                                required autofocus autocomplete="new-password"
                                maxlength="64" placeholder="Ingresa tu usuario o email">
                            @error('login')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback" id="login-error"></div>
                        </div>

                        <!-- Campo Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" 
                                id="password" name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Ingresa tu contraseña segura">
                            
                            <div class="invalid-feedback" id="password-error"></div>
                            
                            <!-- Medidor de fortaleza -->
                            <div class="mt-2">
                                <small id="password-strength" class="form-text"></small>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Recordar sesión</label>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i> Ingresar
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p class="mb-2">¿No tienes cuenta?</p>
                        <a href="{{ route('register') }}" class="btn btn-outline-success">
                            <i class="fas fa-user-plus me-2"></i> Regístrate aquí
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/validation/form_login.js') }}"></script>

@endsection
