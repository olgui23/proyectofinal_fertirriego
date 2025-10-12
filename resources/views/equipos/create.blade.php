@extends('layout')

@section('title', 'Registrar Equipo')

@section('contenido')
<div class="container py-5">
    <div class="main-content-container">
        <h2 class="mb-4 text-center section-title">Registrar Nuevo Equipo</h2>

        <!-- Alertas de validación -->
        @if ($errors->any())
            <div class="alert alert-danger rounded-3 p-3 mb-4" style="background-color:#ffe5e5; color:#842029;">
                <strong>⚠️ Corrige los siguientes errores:</strong>
                <ul class="mt-2 mb-0">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success rounded-3 p-3 mb-4" style="background-color:#c8f7c5; color:#155724;">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        <form action="{{ route('equipos.store') }}" method="POST">
            @csrf

            <!-- Usuario -->
            <div class="mb-4">
                <label for="user_id" class="form-label fw-bold"> Usuario (Agricultor)</label>
                <select name="user_id" class="form-control" required>
                    <option value="">Seleccione...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->nombre_completo }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- MAC y Descripción -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="mac" class="form-label fw-bold"> Dirección MAC</label>
                    <input type="text" name="mac" value="{{ old('mac') }}" class="form-control" placeholder="Ejemplo: AA:BB:CC:DD:EE:FF" required>
                    <small class="text-muted">Formato permitido: AA:BB:CC:DD:EE:FF o AA-BB-CC-DD-EE-FF</small>
                </div>
                <div class="col-md-6">
                    <label for="descripcion" class="form-label fw-bold"> Descripción</label>
                    <input type="text" name="descripcion" value="{{ old('descripcion') }}" class="form-control" placeholder="Ej: Sensor del lote norte">
                </div>
            </div>

            <!-- Ubicación y Fecha -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <label for="ubicacion" class="form-label fw-bold"> Ubicación (nombre del lugar)</label>
                    <input type="text" name="ubicacion" value="{{ old('ubicacion') }}" class="form-control" placeholder="Ej: Invernadero 1">
                </div>
                <div class="col-md-6">
                    <label for="fecha_instalacion" class="form-label fw-bold"> Fecha de instalación</label>
                    <input type="date" name="fecha_instalacion" value="{{ old('fecha_instalacion') }}" class="form-control" required>
                </div>
            </div>

            <!-- Campos ocultos para lat/lng -->
            <input type="hidden" name="lat" id="lat" value="{{ old('lat') }}">
            <input type="hidden" name="lng" id="lng" value="{{ old('lng') }}">

            <!-- Activo -->
            <input type="hidden" name="activo" value="1">

            <!-- Mapa -->
            <div class="mb-4">
                <label class="form-label fw-bold"> Seleccione la ubicación en el mapa:</label>
                <div id="map" style="height: 400px; border-radius: 10px; border: 1px solid #ccc;"></div>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-between mt-4">
                <!-- Botones -->
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary">Guardar</button>
                
                <a href="{{ route('equipos.index') }}" class="btn btn-secondary px-4">
                    <i class="fas fa-arrow-left me-2"></i>Cancelar
                </a>
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
    const defaultLat = -17.393;
    const defaultLng = -66.156;

    let map = L.map('map').setView([defaultLat, defaultLng], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap',
        maxZoom: 19,
    }).addTo(map);

    let marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(map);

    marker.on('dragend', function() {
        let pos = marker.getLatLng();
        document.getElementById('lat').value = pos.lat;
        document.getElementById('lng').value = pos.lng;
    });

    map.on('click', function(e) {
        marker.setLatLng(e.latlng);
        document.getElementById('lat').value = e.latlng.lat;
        document.getElementById('lng').value = e.latlng.lng;
    });

    // Inicializar valores
    document.getElementById('lat').value = defaultLat;
    document.getElementById('lng').value = defaultLng;
});
</script>
@endpush

