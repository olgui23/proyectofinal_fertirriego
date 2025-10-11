@extends('layout')

@section('title', 'Editar Perfil')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-center">Editar Perfil</h5>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <p class="mb-1">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Asumiendo que usas PUT para actualizar --}}

                        <h6 class="mb-3 text-muted">Datos Personales</h6>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre(s)</label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                   id="nombre" name="nombre" value="{{ old('nombre', $user->nombre) }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellido(s)</label>
                            <input type="text" class="form-control @error('apellidos') is-invalid @enderror"
                                   id="apellidos" name="apellidos" value="{{ old('apellidos', $user->apellidos) }}" required>
                            @error('apellidos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror"
                                   id="fecha_nacimiento" name="fecha_nacimiento" 
                                   value="{{ old('fecha_nacimiento', $user->fecha_nacimiento) }}"
                                   max="{{ now()->subYears(18)->format('Y-m-d') }}">
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Género</label>
                            <div class="d-flex gap-3">
                                @php $genero = old('genero', $user->genero); @endphp
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="masculino" 
                                           value="masculino" {{ $genero == 'masculino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="masculino">Masculino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="femenino" 
                                           value="femenino" {{ $genero == 'femenino' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="femenino">Femenino</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="genero" id="otro" 
                                           value="otro" {{ $genero == 'otro' ? 'checked' : '' }}>
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
                                   id="username" name="username" value="{{ old('username', $user->username) }}"
                                   maxlength="20" required>
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Opcional: Permitir cambiar contraseña --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
                            <input type="password" class="form-control" 
                                   id="password" name="password" placeholder="Solo si deseas cambiarla">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="mb-4">
                            <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                            <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror"
                                   id="foto_perfil" name="foto_perfil" accept="image/jpeg, image/png">
                            @error('foto_perfil')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                            @if($user->foto_perfil)
                                <div class="mt-2">
                                    <p>Foto actual:</p>
                                    <img src="{{ asset('storage/' . $user->foto_perfil) }}" alt="Foto de perfil actual" width="100">
                                </div>
                            @endif
                        </div>

                        <div class="d-grid">
                            <button type="submit" id="btnGuardar" class="btn btn-success">
  Guardar cambios
</button>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal de confirmación -->
<div class="modal fade" id="guardadoModal" tabindex="-1" aria-labelledby="guardadoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="guardadoModalLabel">¡Cambios guardados!</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <p>Tu perfil se actualizó correctamente 🌿</p>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const modal = new bootstrap.Modal(document.getElementById('guardadoModal'));

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const submitButton = document.getElementById('btnGuardar');
        
        // Cambiar texto del botón para indicar carga
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';
        submitButton.disabled = true;

        fetch(form.action, {
            method: 'POST', // Laravel simula PUT con POST
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                modal.show();
                setTimeout(() => {
                    window.location.href = data.redirect_url || '/dashboard';
                }, 2500);
            } else {
                throw new Error(data.message || 'Error al guardar');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Ocurrió un error al guardar los cambios: " + error.message);
            
            // Restaurar botón
            submitButton.innerHTML = 'Guardar cambios';
            submitButton.disabled = false;
        });
    });
});
</script>
@endsection