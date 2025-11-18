@extends('layout')

@section('title', 'Gestión de Equipos')

@section('contenido')
<div class="container py-5">
    <div class="main-content-container">
        <!-- Encabezado -->
        <div class="text-center mb-4">
            <h1 class="section-title">Equipos Registrados</h1>
            <p class="calendar-subtitle">Listado, detalles y gestión de equipos de monitoreo</p>
        </div>

        <!-- Botón registrar -->
        <div class="text-end mb-3">
            <a href="{{ route('equipos.create') }}" class="btn btn-success">
                <i class="fas fa-plus-circle me-2"></i>Registrar Nuevo Equipo
            </a>

            <a href="{{ route('equipos.pdf-view') }}" class="btn btn-outline-success ms-2">
                <i class="fas fa-file-pdf me-2"></i>Ver PDF Equipos
            </a>
        </div>

        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($equipos->count() > 0)
        <!-- Tarjetas de equipos -->
        <div class="row row-cols-1 row-cols-md-2 g-4">
            @foreach($equipos as $equipo)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">
                            <i class="fas fa-microchip me-2"></i>MAC: {{ $equipo->mac }}
                        </h5>
                        <p class="mb-2"><strong>Usuario:</strong> {{ optional($equipo->user)->nombre_completo ?? 'N/A' }}</p>
                        <p><strong>Ubicación:</strong> {{ $equipo->ubicacion ?? 'No especificada' }}</p>

                        <ul class="list-unstyled small mb-3">
                            <li><i class="fas fa-map-marker-alt me-2"></i>Lat/Lng: {{ $equipo->lat ?? '-' }}, {{ $equipo->lng ?? '-' }}</li>
                            <li><i class="fas fa-calendar me-2"></i>Instalado el: {{ $equipo->fecha_instalacion ?? 'N/A' }}</li>
                            <li><i class="fas fa-check-circle me-2"></i>Activo: {{ $equipo->activo ? 'Sí' : 'No' }}</li>
                        </ul>

                        <div class="d-flex justify-content-between">
                            <button class="btn btn-info btn-sm btn-ver" data-id="{{ $equipo->id }}">
                                <i class="fas fa-eye me-1"></i>Ver Detalles
                            </button>
                            <a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            <form action="{{ route('equipos.destroy', $equipo->id) }}" method="POST" onsubmit="return confirm('¿Eliminar equipo?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash me-1"></i>Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="mt-4">
            {{ $equipos->links() }}
        </div>

        @else
            <div class="alert alert-info text-center mt-4">
                <i class="fas fa-info-circle me-2"></i>No hay equipos registrados aún.
            </div>
        @endif
    </div>
</div>

<!-- Modal de detalles con mapa a la izquierda -->
<div class="modal fade" id="equipoModal" tabindex="-1" aria-labelledby="equipoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content border-success">
      <div class="modal-header" style="background-color: #64A500; color: #fff;">
        <h5 class="modal-title" id="equipoModalLabel">Detalles del Equipo</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="row">
            <!-- Columna izquierda con mapa -->
            <div class="col-md-6 mb-3">
                <div id="map" style="width: 100%; height: 350px; border: 1px solid #64A500; border-radius: 5px;"></div>
            </div>
            <!-- Columna derecha con datos -->
            <div class="col-md-6 mb-3">
                <p><strong>ID:</strong> <span id="equipo-id"></span></p>
                <p><strong>Usuario:</strong> <span id="equipo-usuario"></span></p>
                <p><strong>MAC:</strong> <span id="equipo-mac"></span></p>
                <p><strong>Descripción:</strong> <span id="equipo-descripcion"></span></p>
                <p><strong>Ubicación:</strong> <span id="equipo-ubicacion"></span></p>
                <p><strong>Latitud:</strong> <span id="equipo-lat"></span></p>
                <p><strong>Longitud:</strong> <span id="equipo-lng"></span></p>
                <p><strong>Activo:</strong> <span id="equipo-activo"></span></p>
                <p><strong>Fecha Instalación:</strong> <span id="equipo-fecha"></span></p>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const botones = document.querySelectorAll('.btn-ver');
    const modal = new bootstrap.Modal(document.getElementById('equipoModal'));
    let map, marker;

    function initMap(lat, lng) {
        if(!lat || !lng) return;
        const position = { lat: parseFloat(lat), lng: parseFloat(lng) };
        if (!map) {
            map = new google.maps.Map(document.getElementById("map"), {
                zoom: 15,
                center: position,
            });
            marker = new google.maps.Marker({
                position,
                map: map,
            });
        } else {
            map.setCenter(position);
            marker.setPosition(position);
        }
    }

    botones.forEach(boton => {
        boton.addEventListener('click', function () {
            const id = this.dataset.id;

            fetch(`{{ url('equipos') }}/${id}`, { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                document.getElementById('equipo-id').textContent = data.id;
                document.getElementById('equipo-usuario').textContent = data.user ? data.user.nombre_completo : 'N/A';
                document.getElementById('equipo-mac').textContent = data.mac;
                document.getElementById('equipo-descripcion').textContent = data.descripcion ?? 'N/A';
                document.getElementById('equipo-ubicacion').textContent = data.ubicacion ?? 'N/A';
                document.getElementById('equipo-lat').textContent = data.lat ?? 'N/A';
                document.getElementById('equipo-lng').textContent = data.lng ?? 'N/A';
                document.getElementById('equipo-fecha').textContent = data.fecha_instalacion ?? 'N/A';
                document.getElementById('equipo-activo').textContent = data.activo ? 'Sí' : 'No';

                modal.show();

                if(data.lat && data.lng) {
                    initMap(data.lat, data.lng);
                }
            })
            .catch(err => console.error(err));
        });
    });
});
</script>

<!-- Google Maps API -->
<script src="https://maps.googleapis.com/maps/api/js?key=TU_API_KEY"></script>
@endpush
