@extends('layout')

@section('title', 'Gestión de Agricultores')

@section('contenido')
<div class="container py-5">
    <div class="main-content-container">

        <!-- Encabezado -->
        <div class="text-center mb-4">
            <h1 class="section-title">Agricultores Registrados</h1>
            <p class="calendar-subtitle">Listado, detalles y gestión de agricultores</p>
        </div>

        <!-- Botón registrar -->
        <div class="text-end mb-3">
            <a href="{{ route('administrador.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle me-2"></i>Registrar Nuevo Agricultor
            </a>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($agricultores->count() > 0)
        <!-- Tabla de agricultores -->
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre Completo</th>
                        <th>Usuario</th>
                        <th>Email</th>
                        <th>Género</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($agricultores as $agricultor)
                    <tr>
                        <td>{{ $agricultor->id }}</td>
                        <td>{{ $agricultor->nombre }} {{ $agricultor->apellidos }}</td>
                        <td>{{ $agricultor->username }}</td>
                        <td>{{ $agricultor->email }}</td>
                        <td>{{ ucfirst($agricultor->genero) }}</td>
                        <td class="d-flex gap-2">
                            <!-- Botón Ver Modal -->
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#agricultorModal{{ $agricultor->id }}">
                                <i class="fas fa-eye me-1"></i>Ver
                            </button>

                            <!-- Editar -->
                            <a href="{{ route('administrador.edit', $agricultor->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>

                            <!-- Eliminar -->
                            <form action="{{ route('administrador.destroy', $agricultor->id) }}" method="POST" onsubmit="return confirm('¿Eliminar agricultor?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash me-1"></i>Eliminar</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal -->
                    <div class="modal fade" id="agricultorModal{{ $agricultor->id }}" tabindex="-1" aria-labelledby="agricultorModalLabel{{ $agricultor->id }}" aria-hidden="true">
                      <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                          <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="agricultorModalLabel{{ $agricultor->id }}">Detalles de {{ $agricultor->nombre }} {{ $agricultor->apellidos }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                          </div>
                          <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Nombre:</strong> {{ $agricultor->nombre }}</div>
                                <div class="col-md-6"><strong>Apellidos:</strong> {{ $agricultor->apellidos }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Usuario:</strong> {{ $agricultor->username }}</div>
                                <div class="col-md-6"><strong>Email:</strong> {{ $agricultor->email }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6"><strong>Fecha Nacimiento:</strong> {{ $agricultor->fecha_nacimiento }}</div>
                                <div class="col-md-6"><strong>Género:</strong> {{ ucfirst($agricultor->genero) }}</div>
                            </div>
                            @if($agricultor->foto_perfil)
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <strong>Foto de Perfil:</strong><br>
                                    <img src="{{ asset('storage/' . $agricultor->foto_perfil) }}" alt="Foto de {{ $agricultor->nombre }}" class="img-fluid rounded" style="max-height:200px;">
                                </div>
                            </div>
                            @endif
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- Fin Modal -->

                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $agricultores->links() }}
        </div>

        @else
            <div class="alert alert-info text-center mt-4">
                <i class="fas fa-info-circle me-2"></i>No hay agricultores registrados aún.
            </div>
        @endif
    </div>
</div>
@endsection
