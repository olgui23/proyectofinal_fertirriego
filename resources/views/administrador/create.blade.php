@extends('layout')

@section('title', 'Registrar Agricultor')

@section('contenido')
<div class="container my-6">
    <div class="shadow-sm p-5 rounded" style="background: white;">

        <h2 class="mb-4" style="color: #64A500; font-family: 'Merriweather', serif; font-weight: 700;">
            Registrar Nuevo Agricultor
        </h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('administrador.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <h6 class="mb-3 text-muted">Datos Personales</h6>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre(s)</label>
                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}" required>
                    @error('nombre')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Apellido(s)</label>
                    <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos') }}" required>
                    @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" 
       class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
       value="{{ old('fecha_nacimiento') }}" 
       max="{{ now()->subYears(18)->format('Y-m-d') }}"
       required>

                    @error('fecha_nacimiento')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6">
                    <label class="form-label">Género</label>
                    <div class="d-flex gap-3 mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" value="masculino" {{ old('genero') == 'masculino' ? 'checked' : '' }}>
                            <label class="form-check-label">Masculino</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" value="femenino" {{ old('genero') == 'femenino' ? 'checked' : '' }}>
                            <label class="form-check-label">Femenino</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" value="otro" {{ old('genero') == 'otro' ? 'checked' : '' }}>
                            <label class="form-check-label">Otro</label>
                        </div>
                    </div>
                    @error('genero')<div class="text-danger small">{{ $message }}</div>@enderror
                </div>
            </div>

            <h6 class="mb-3 text-muted mt-4">Datos de Cuenta</h6>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Usuario</label>
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" maxlength="20" required>
                    @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-4">
                    <label class="form-label">Foto de Perfil</label>
                    <input type="file" name="foto_perfil" class="form-control @error('foto_perfil') is-invalid @enderror" accept="image/jpeg, image/png">
                    @error('foto_perfil')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn" style="background-color: #64A500; color: white; font-weight: 600; padding: 12px;">
                    <i class="fas fa-user-plus me-2"></i>Registrar Agricultor
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #64A500 !important;
        box-shadow: 0 0 0 0.25rem rgba(100, 165, 0, 0.25);
    }

    .form-check-input:checked {
        background-color: #64A500;
        border-color: #64A500;
    }
</style>
@endsection
