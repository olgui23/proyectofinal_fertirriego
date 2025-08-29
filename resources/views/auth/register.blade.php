@extends('layout')

@section('title', 'Registro')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-center">Crear Cuenta</h5>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-1">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register') }}" id="register-form" enctype="multipart/form-data">
                        @csrf

                        <h6 class="mb-3 text-muted">Datos Personales</h6>
                        
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre(s)</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellido(s)</label>
                            <input type="text" class="form-control @error('apellidos') is-invalid @enderror" 
                                   id="apellidos" name="apellidos" value="{{ old('apellidos') }}" required>
                            @error('apellidos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                   id="fecha_nacimiento" name="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento') }}" max="{{ now()->subYears(18)->format('Y-m-d') }}">
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Género</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="masculino" 
                                           value="masculino" {{ old('genero') == 'masculino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="masculino">Masculino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="femenino" 
                                           value="femenino" {{ old('genero') == 'femenino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="femenino">Femenino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="otro" 
                                           value="otro" {{ old('genero') == 'otro' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="otro">Otro</label>
                                </div>
                            </div>
                            @error('genero')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <h6 class="mb-3 text-muted">Datos de Cuenta</h6>

                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                   id="username" name="username" value="{{ old('username') }}" 
                                   maxlength="20" placeholder="Ingresa tu nombre de cuenta" autofocus>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback" id="username-error"></div>
                        </div>




                        <!-- Campo Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="Ingresa tu email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="invalid-feedback" id="email-error"></div>
                        </div>


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

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" id="password_confirmation" 
                                   name="password_confirmation" required 
                                   placeholder="Re-escribe tu contraseña">
                            <div class="invalid-feedback" id="password_confirmation-error"></div>
                        </div>

                        <div class="mb-4">
                            <label for="foto_perfil" class="form-label">Foto de Perfil (Opcional)</label>
                            <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror" 
                                   id="foto_perfil" name="foto_perfil" accept="image/jpeg, image/png">
                            @error('foto_perfil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Formatos: JPEG o PNG (Máx. 2MB)</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success btn-lg" id="submit-button">
                                <i class="fas fa-user-plus me-2"></i> Registrarse
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión aquí</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/validation/form_register.js') }}"></script>
@endsection