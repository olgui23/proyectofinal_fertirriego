@extends('layout')

@section('contenido')
<div class="container py-5">
    <div class="main-content-container">
        <h2 class="mb-4">Registrar Equipo</h2>

        <form action="{{ route('equipos.store') }}" method="POST">
            @csrf

            <!-- Usuario -->
            <div class="mb-4">
    <label for="user_id">Usuario (Agricultor)</label>
    <select name="user_id" class="form-control" required>
        <option value="">Seleccione...</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}"
                {{ isset($equipo) && $equipo->user_id == $user->id ? 'selected' : '' }}>
                {{ $user->nombre_completo }} ({{ $user->email }})
            </option>
        @endforeach
    </select>
</div>

            <!-- MAC y Descripción -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="mac" class="form-label">MAC</label>
                    <input type="text" name="mac" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <input type="text" name="descripcion" class="form-control">
                </div>
            </div>

            <!-- Ubicación y Fecha -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="ubicacion" class="form-label">Ubicación (nombre del lugar)</label>
                    <input type="text" name="ubicacion" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="fecha_instalacion" class="form-label">Fecha de instalación</label>
                    <input type="date" name="fecha_instalacion" class="form-control">
                </div>
            </div>

            <!-- Campos ocultos para lat/lng -->
            <input type="hidden" name="lat" id="lat">
            <input type="hidden" name="lng" id="lng">

            <!-- Campo oculto: Activo (por defecto Sí) -->
            <input type="hidden" name="activo" value="1">

            <!-- Mapa -->
            <div class="mb-4">
                <label class="form-label">Seleccione la ubicación en el mapa:</label>
                <div id="map" style="height: 400px;"></div>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('equipos.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- Leaflet.js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let map = L.map('map').setView([-17.393, -66.156], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap',
        maxZoom: 19,
    }).addTo(map);

    let marker = L.marker([-17.393, -66.156], {draggable:true}).addTo(map);

    marker.on('dragend', function(e) {
        let position = marker.getLatLng();
        document.getElementById('lat').value = position.lat;
        document.getElementById('lng').value = position.lng;
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('lat').value = e.latlng.lat;
        document.getElementById('lng').value = e.latlng.lng;
    });

    let initialPos = marker.getLatLng();
    document.getElementById('lat').value = initialPos.lat;
    document.getElementById('lng').value = initialPos.lng;
});
</script>
@endpush
