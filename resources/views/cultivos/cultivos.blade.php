@extends('layout')

@section('title', 'Cultivos')

@section('contenido')
<section class="page-section clearfix">
    <div class="container">
        <div class="row mb-5">
            <!-- Sección de Cultivos -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h2 class="h4 mb-0">Listado de Cultivos</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Variedad</th>
                                        <th>Fecha Siembra</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cultivos as $cultivo)
                                    <tr>
                                        <td>{{ $cultivo->nombre }}</td>
                                        <td>{{ $cultivo->variedad }}</td>
                                        <td>{{ date('d/m/Y', strtotime($cultivo->fecha_siembra)) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $cultivo->estado ? 'success' : 'secondary' }}">
                                                {{ $cultivo->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary">Detalles</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección Meteorológica -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-info text-white">
                        <h2 class="h4 mb-0">Datos Meteorológicos</h2>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h3 class="h5">Condiciones Actuales</h3>
                                <p class="mb-1"><i class="bi bi-thermometer-half me-2"></i> 22°C</p>
                                <p class="mb-1"><i class="bi bi-droplet me-2"></i> Humedad: 65%</p>
                                <p class="mb-1"><i class="bi bi-wind me-2"></i> Viento: 10 km/h</p>
                            </div>
                            <div class="display-4 text-info">
                                <i class="bi bi-cloud-sun"></i>
                            </div>
                        </div>
                        
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <small class="text-muted">Precipitación acumulada: 15mm (últimas 24h)</small>
                        
                        <hr>
                        
                        <h3 class="h5 mt-3">Pronóstico 7 días</h3>
                        <div class="row text-center">
                            <div class="col">
                                <p class="mb-1">Hoy</p>
                                <i class="bi bi-sun text-warning"></i>
                                <p class="mb-0">24°C</p>
                            </div>
                            <div class="col">
                                <p class="mb-1">Mañ</p>
                                <i class="bi bi-cloud-sun text-info"></i>
                                <p class="mb-0">22°C</p>
                            </div>
                            <div class="col">
                                <p class="mb-1">Mier</p>
                                <i class="bi bi-cloud-rain text-primary"></i>
                                <p class="mb-0">19°C</p>
                            </div>
                            <div class="col">
                                <p class="mb-1">Jue</p>
                                <i class="bi bi-cloud text-secondary"></i>
                                <p class="mb-0">20°C</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Cuidados para Lechuga -->
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h2 class="h4 mb-0">Guía de Cuidados para Lechuga</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="text-center p-3 border rounded bg-light">
                            <i class="bi bi-droplet-fill display-4 text-primary mb-3"></i>
                            <h3 class="h5">Riego</h3>
                            <ul class="text-start">
                                <li>1-2 veces por día en verano</li>
                                <li>Mantener suelo húmedo</li>
                                <li>Evitar encharcamientos</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="text-center p-3 border rounded bg-light">
                            <i class="bi bi-brightness-high-fill display-4 text-warning mb-3"></i>
                            <h3 class="h5">Luz Solar</h3>
                            <ul class="text-start">
                                <li>4-6 horas diarias</li>
                                <li>Sombra parcial en climas cálidos</li>
                                <li>Evitar sol intenso del mediodía</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="text-center p-3 border rounded bg-light">
                            <i class="bi bi-thermometer-sun display-4 text-danger mb-3"></i>
                            <h3 class="h5">Temperatura</h3>
                            <ul class="text-start">
                                <li>Óptima: 15-20°C</li>
                                <li>Tolerancia: 7-24°C</li>
                                <li>Proteger de heladas</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-warning">
                    <h4 class="alert-heading"><i class="bi bi-exclamation-triangle-fill"></i> Consejos Clave</h4>
                    <ul class="mb-0">
                        <li>Rotación de cultivos cada temporada</li>
                        <li>Controlar plagas como pulgones y babosas</li>
                        <li>Cosechar por la mañana para mayor frescura</li>
                        <li>Espaciamiento entre plantas: 20-30 cm</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Estilos adicionales -->
<style>
    .card {
        border-radius: 10px;
        border: none;
        overflow: hidden;
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
        padding: 1rem 1.5rem;
    }
    .table-hover tbody tr:hover {
        background-color: rgba(40, 167, 69, 0.1);
    }
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }
    .progress {
        border-radius: 5px;
    }
</style>

<!-- Incluir iconos de Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">
@endsection