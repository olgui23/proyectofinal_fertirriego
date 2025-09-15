@extends('layout')

@section('title', 'Buenas Prácticas')

@section('contenido')
<div class="container py-5">
    <!-- Contenedor principal con sombra -->
    <div class="main-content-container">
        <!-- Encabezado -->
        <div class="text-center mb-5">
            <h1 class="plagas-title">BUENAS PRÁCTICAS AGRÍCOLAS</h1>
            <p class="calendar-subtitle">Técnicas específicas para el cultivo de lechuga en Tiquipaya</p>
        </div>

        <!-- Sección de prácticas -->
        <div class="practice-section mb-5">
            <div class="practice-header bg-primary-green text-white">
                <h3><i class="fas fa-tractor me-2"></i>Prácticas de Cultivo</h3>
            </div>
            <div class="practice-body">
                <div class="row">
                    <!-- Práctica 1 -->
                    <div class="col-md-6 mb-4">
                        <div class="practice-card h-100">
                            <div class="practice-img-container">
                                <img src="{{ asset('images/tierra.jpg') }}" alt="Preparación de suelo" class="practice-img">
                            </div>
                            <div class="practice-content">
                                <h4 class="practice-title">Preparación del suelo</h4>
                                <div class="practice-meta">
                                    <span class="badge bg-light-green"><i class="fas fa-calendar-alt me-1"></i> Pre-siembra</span>
                                    <span class="badge bg-light-green"><i class="fas fa-clock me-1"></i> 2-3 semanas antes</span>
                                </div>
                                <ul class="practice-list">
                                    <li>Análisis de suelo obligatorio</li>
                                    <li>Arado a 20-25 cm de profundidad</li>
                                    <li>Incorporación de materia orgánica (5 kg/m²)</li>
                                    <li>Nivelación para evitar encharcamientos</li>
                                </ul>
                                <div class="practice-tip bg-leaf text-white">
                                    <i class="fas fa-lightbulb me-2"></i>En Tiquipaya, añadir ceniza volcánica para mejorar textura
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Práctica 2 -->
                    <div class="col-md-6 mb-4">
                        <div class="practice-card h-100">
                            <div class="practice-img-container">
                                <img src="{{ asset('images/riego.jpg') }}" alt="Sistema de riego" class="practice-img">
                            </div>
                            <div class="practice-content">
                                <h4 class="practice-title">Manejo de riego</h4>
                                <div class="practice-meta">
                                    <span class="badge bg-light-green"><i class="fas fa-calendar-alt me-1"></i> Todo el ciclo</span>
                                    <span class="badge bg-light-green"><i class="fas fa-clock me-1"></i> Mañana temprano</span>
                                </div>
                                <ul class="practice-list">
                                    <li>Riego por goteo o microaspersión</li>
                                    <li>Frecuencia según etapa de crecimiento</li>
                                    <li>Evitar mojar follaje para prevenir hongos</li>
                                    <li>Monitorear humedad con tensiómetro</li>
                                </ul>
                                <div class="practice-tip bg-leaf text-white">
                                    <i class="fas fa-lightbulb me-2"></i>En épocas secas, aumentar riego pero sin encharcar
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendario agrícola -->
        <div class="practice-section mb-5">
            <div class="practice-header bg-primary-green text-white">
                <h3><i class="fas fa-calendar-alt me-2"></i>Calendario Agrícola - Tiquipaya</h3>
            </div>
            <div class="practice-body">
                <div class="table-responsive">
                    <table class="table practice-calendar">
                        <thead>
                            <tr>
                                <th>Mes</th>
                                <th>Actividades</th>
                                <th>Variedades recomendadas</th>
                                <th>Precauciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Enero-Febrero</strong></td>
                                <td>Preparación suelos, siembra</td>
                                <td>Romana, Crespa</td>
                                <td>Proteger de lluvias intensas</td>
                            </tr>
                            <tr>
                                <td><strong>Marzo-Abril</strong></td>
                                <td>Cosecha principal, control plagas</td>
                                <td>Mantequilla, Iceberg</td>
                                <td>Vigilar pulgones y mildiu</td>
                            </tr>
                            <tr>
                                <td><strong>Mayo-Junio</strong></td>
                                <td>Rotación cultivos, abonos verdes</td>
                                <td>-</td>
                                <td>Proteger suelos de erosión</td>
                            </tr>
                            <tr>
                                <td><strong>Julio-Agosto</strong></td>
                                <td>Preparación nuevos ciclos</td>
                                <td>Resistentes al frío</td>
                                <td>Cubrir cultivos en noches frías</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Buenas prácticas ambientales -->
        <div class="practice-section">
            <div class="practice-header bg-primary-green text-white">
                <h3><i class="fas fa-leaf me-2"></i>Prácticas Sostenibles</h3>
            </div>
            <div class="practice-body">
                <div class="row">
                    <!-- Práctica ambiental 1 -->
                    <div class="col-md-4 mb-4">
                        <div class="eco-card h-100">
                            <div class="eco-icon bg-leaf">
                                <i class="fas fa-recycle"></i>
                            </div>
                            <h4 class="eco-title">Manejo de residuos</h4>
                            <ul class="eco-list">
                                <li>Compostaje de restos vegetales</li>
                                <li>Reciclaje de plásticos agrícolas</li>
                                <li>Tratamiento de aguas residuales</li>
                                <li>Uso de embalajes biodegradables</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Práctica ambiental 2 -->
                    <div class="col-md-4 mb-4">
                        <div class="eco-card h-100">
                            <div class="eco-icon bg-leaf">
                                <i class="fas fa-water"></i>
                            </div>
                            <h4 class="eco-title">Conservación de agua</h4>
                            <ul class="eco-list">
                                <li>Sistemas de riego eficientes</li>
                                <li>Captación de agua lluvia</li>
                                <li>Mulching orgánico</li>
                                <li>Monitoreo de humedad</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Práctica ambiental 3 -->
                    <div class="col-md-4 mb-4">
                        <div class="eco-card h-100">
                            <div class="eco-icon bg-leaf">
                                <i class="fas fa-bug"></i>
                            </div>
                            <h4 class="eco-title">Control biológico</h4>
                            <ul class="eco-list">
                                <li>Corredores ecológicos</li>
                                <li>Hoteles de insectos</li>
                                <li>Trampas con feromonas</li>
                                <li>Uso de depredadores naturales</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection