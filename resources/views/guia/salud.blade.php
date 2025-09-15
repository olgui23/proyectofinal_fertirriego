@extends('layout')

@section('title', 'Salud Vegetal')

@section('contenido')
<div class="container py-5">
    <!-- Contenedor principal con sombra -->
    <div class="main-content-container">
        <!-- Encabezado -->
        <div class="text-center mb-5 mt-4">
        <h1 class="salud-title">SALUD VEGETAL</h1>
        <p class="salud-subtitle">Diagnóstico y manejo integral de problemas en el cultivo de lechuga</p>
    </div>


        <!-- PASO 1: Observa los síntomas -->
    <div class="mb-5">
        <h2 class="salud-step-title">1. Observa los síntomas</h2>
        <div class="salud-img-grid">
            <!-- Imagen de hojas -->
            <div class="salud-img-card">
                <img src="{{ asset('images/sintomas.jpg') }}" alt="Síntomas en hojas">
                <h5>Problemas en hojas</h5>
                <ul>
                    <li>Manchas</li>
                    <li>Amarillamiento</li>
                    <li>Deformaciones</li>
                </ul>
            </div>
            <!-- Imagen de raíces -->
            <div class="salud-img-card">
                <img src="{{ asset('images/raices.jpg') }}" alt="Síntomas en raíces">
                <h5>Problemas en raíces</h5>
                <ul>
                    <li>Pudrición</li>
                    <li>Raíces oscuras</li>
                    <li>Falta de desarrollo</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- PASO 2: Analiza posibles causas -->
    <div class="mb-5">
        <h2 class="salud-step-title">2. Analiza posibles causas</h2>
        <div class="salud-cause-list">
            <div class="cause-item">
                <div class="cause-icon bg-danger">
                    <i class="fas fa-bug"></i>
                </div>
                <div>
                    <h5>Plagas</h5>
                    <p>Insectos, ácaros o nematodos que dañan la planta</p>
                </div>
            </div>
            <div class="cause-item">
                <div class="cause-icon bg-warning">
                    <i class="fas fa-virus"></i>
                </div>
                <div>
                    <h5>Enfermedades</h5>
                    <p>Hongos, bacterias o virus que afectan el desarrollo</p>
                </div>
            </div>
            <div class="cause-item">
                <div class="cause-icon bg-info">
                    <i class="fas fa-flask"></i>
                </div>
                <div>
                    <h5>Desequilibrios nutricionales</h5>
                    <p>Excesos o deficiencias de nutrientes esenciales</p>
                </div>
            </div>
        </div>
    </div>

        <!-- Guía de nutrientes -->
        <div class="card nutrient-card mb-5">
            <div class="card-header bg-primary-green text-white">
                <h3 class="mb-0"><i class="fas fa-leaf me-2"></i>Guía de Nutrientes Esenciales</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table nutrient-table">
                        <thead class="bg-light-green text-white">
                            <tr>
                                <th>Nutriente</th>
                                <th>Función</th>
                                <th>Síntomas de deficiencia</th>
                                <th>Fuentes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Nitrógeno (N)</strong></td>
                                <td>Crecimiento vegetativo</td>
                                <td>Amarillamiento de hojas viejas</td>
                                <td>Urea, estiércol, harina de sangre</td>
                            </tr>
                            <tr>
                                <td><strong>Fósforo (P)</strong></td>
                                <td>Desarrollo radicular</td>
                                <td>Hojas verde oscuro con tonos púrpura</td>
                                <td>Superfosfato, roca fosfórica</td>
                            </tr>
                            <tr>
                                <td><strong>Potasio (K)</strong></td>
                                <td>Resistencia a estrés</td>
                                <td>Necrosis en bordes de hojas viejas</td>
                                <td>Sulfato de potasio, ceniza</td>
                            </tr>
                            <tr>
                                <td><strong>Calcio (Ca)</strong></td>
                                <td>Estructura celular</td>
                                <td>Necrosis en hojas jóvenes (tip burn)</td>
                                <td>Nitrato de calcio, yeso</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Manejo integrado -->
        <div class="card management-card">
            <div class="card-header bg-primary-green text-white">
                <h3 class="mb-0"><i class="fas fa-tasks me-2"></i>Manejo Integrado de Salud Vegetal</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="strategy-card h-100">
                            <div class="strategy-icon bg-leaf">
                                <i class="fas fa-seedling"></i>
                            </div>
                            <h4 class="strategy-title">Prácticas Preventivas</h4>
                            <ul class="strategy-list">
                                <li>Selección de variedades resistentes</li>
                                <li>Rotación de cultivos (2-3 años)</li>
                                <li>Uso de semillas certificadas</li>
                                <li>Esterilización de sustratos</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="strategy-card h-100">
                            <div class="strategy-icon bg-leaf">
                                <i class="fas fa-binoculars"></i>
                            </div>
                            <h4 class="strategy-title">Monitoreo Regular</h4>
                            <ul class="strategy-list">
                                <li>Inspección visual semanal</li>
                                <li>Trampas adhesivas amarillas</li>
                                <li>Registro de incidencias</li>
                                <li>Análisis foliares periódicos</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="strategy-card h-100">
                            <div class="strategy-icon bg-leaf">
                                <i class="fas fa-spray-can"></i>
                            </div>
                            <h4 class="strategy-title">Intervenciones</h4>
                            <ul class="strategy-list">
                                <li>Control biológico (predadores)</li>
                                <li>Biopreparados (neem, ajo)</li>
                                <li>Fertilización balanceada</li>
                                <li>Poda sanitaria</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection