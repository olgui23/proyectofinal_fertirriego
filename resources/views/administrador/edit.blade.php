@extends('layout')

@section('title', 'Editar Agricultor')

@section('contenido')
<div class="container my-6">
    <div class="shadow-sm p-5 rounded" style="background: white;">

        <h2 class="mb-4" style="color: #64A500; font-family: 'Merriweather', serif; font-weight: 700;">
            Editar Agricultor
        </h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('administrador.update', $agricultor->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <h6 class="mb-3 text-muted">Datos Personales</h6>

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre(s)</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $agricultor->nombre) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Apellido(s)</label>
                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos', $agricultor->apellidos) }}" required>
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label class="form-label">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" class="form-control" 
                           value="{{ old('fecha_nacimiento', $agricultor->fecha_nacimiento) }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Género</label>
                    <div class="d-flex gap-3 mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" value="masculino" {{ old('genero', $agricultor->genero) == 'masculino' ? 'checked' : '' }}>
                            <label class="form-check-label">Masculino</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" value="femenino" {{ old('genero', $agricultor->genero) == 'femenino' ? 'checked' : '' }}>
                            <label class="form-check-label">Femenino</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="genero" value="otro" {{ old('genero', $agricultor->genero) == 'otro' ? 'checked' : '' }}>
                            <label class="form-check-label">Otro</label>
                        </div>
                    </div>
                </div>
            </div>

            <h6 class="mb-3 text-muted mt-4">Datos de Cuenta</h6>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Usuario</label>
                    <input type="text" name="username" class="form-control" value="{{ old('username', $agricultor->username) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $agricultor->email) }}" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Foto de Perfil (Opcional)</label>
                    @if($agricultor->foto_perfil)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $agricultor->foto_perfil) }}" 
                                 alt="Foto actual" class="img-thumbnail rounded" style="max-height: 150px;">
                        </div>
                    @endif
                    <input type="file" name="foto_perfil" class="form-control" accept="image/jpeg, image/png">
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label class="form-label">Nueva Contraseña</label>
                    <input type="password" name="password" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Confirmar Contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control">
                </div>
            </div>

            <div class="d-grid mt-4">
                <button type="submit" class="btn" style="background-color: #64A500; color: white; font-weight: 600; padding: 12px;">
                    <i class="fas fa-save me-2"></i>Actualizar Agricultor
                </button>
            </div>

            <div class="mt-3 text-center">
                <a href="{{ route('administrador.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Volver al listado
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #64A500 !important;
        box-shadow: 0 0 0 0.25rem rgba(100, 165, 0, 0.25);
    }

    .form-check-input:checked {
        background-color: #64A500;
        border-color: #64A500;
    }
</style>
@endsection
