@extends('layout')

@section('title', 'Plagas & Enfermedades')

@section('contenido')
<div class="container py-5">
    <!-- Contenedor principal con sombra -->
    <div class="main-content-container">
        <!-- Encabezado -->
        <div class="text-center mb-5">
            <h1 class="fw-bold">PLAGAS & ENFERMEDADES</h1>
            <p class="calendar-subtitle">Identificación y manejo de problemas comunes en el cultivo de lechuga</p>
        </div>

        <!-- Sistema de pestañas -->
        <ul class="nav nav-tabs pest-tabs mb-4" id="pestTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="plagas-tab" data-bs-toggle="tab" data-bs-target="#plagas" type="button" role="tab">
                    <i class="fas fa-bug me-2"></i>Plagas Comunes
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="enfermedades-tab" data-bs-toggle="tab" data-bs-target="#enfermedades" type="button" role="tab">
                    <i class="fas fa-virus me-2"></i>Enfermedades
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="prevencion-tab" data-bs-toggle="tab" data-bs-target="#prevencion" type="button" role="tab">
                    <i class="fas fa-shield-alt me-2"></i>Prevención
                </button>
            </li>
        </ul>

        <!-- Contenido de pestañas -->
        <div class="tab-content" id="pestTabsContent">
            <!-- Pestaña de Plagas -->
            <div class="tab-pane fade show active" id="plagas" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <!-- Plaga 1 -->
                    <div class="col">
                        <div class="card pest-card h-100">
                            <div class="pest-img-container">
                                <img src="{{ asset('images/pulgones.jpg') }}" class="card-img-top pest-img" alt="Pulgones">
                                <span class="pest-danger-level bg-danger">Alta peligrosidad</span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title pest-title">Pulgones</h3>
                                <div class="pest-meta mb-3">
                                    <span class="badge bg-warning me-2"><i class="fas fa-calendar-alt me-1"></i> Todo el año</span>
                                    <span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i> Daño rápido</span>
                                </div>
                                <p class="card-text">Pequeños insectos que chupan la savia y transmiten virus. Se agrupan en el envés de las hojas.</p>
                                
                                <div class="pest-symptoms mb-3">
                                    <h5 class="text-leaf"><i class="fas fa-eye me-2"></i>Síntomas:</h5>
                                    <ul>
                                        <li>Hojas enrolladas o deformadas</li>
                                        <li>Presencia de melaza (sustancia pegajosa)</li>
                                        <li>Hongo negrilla (fumagina)</li>
                                    </ul>
                                </div>
                                
                                <div class="pest-solution">
                                    <h5 class="text-leaf"><i class="fas fa-spray-can me-2"></i>Manejo:</h5>
                                    <ul class="pest-solution-list">
                                        <li><strong>Preventivo:</strong> Cubiertas flotantes, control de hormigas</li>
                                        <li><strong>Biológico:</strong> Crisopas, mariquitas</li>
                                        <li><strong>Químico:</strong> Jabones insecticidas, neem</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Plaga 2 -->
                    <div class="col">
                        <div class="card pest-card h-100">
                            <div class="pest-img-container">
                                <img src="{{ asset('images/minador.jpg') }}" class="card-img-top pest-img" alt="Minador">
                                <span class="pest-danger-level bg-warning">Media peligrosidad</span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title pest-title">Minador de hojas</h3>
                                <div class="pest-meta mb-3">
                                    <span class="badge bg-warning me-2"><i class="fas fa-calendar-alt me-1"></i> Temporada cálida</span>
                                    <span class="badge bg-warning"><i class="fas fa-exclamation-triangle me-1"></i> Daño estético</span>
                                </div>
                                <p class="card-text">Larvas que excavan galerías dentro de las hojas, reduciendo la capacidad fotosintética.</p>
                                
                                <div class="pest-symptoms mb-3">
                                    <h5 class="text-leaf"><i class="fas fa-eye me-2"></i>Síntomas:</h5>
                                    <ul>
                                        <li>Senderos blancos y sinuosos en hojas</li>
                                        <li>Hojas secas y quebradizas</li>
                                        <li>Reducción del crecimiento</li>
                                    </ul>
                                </div>
                                
                                <div class="pest-solution">
                                    <h5 class="text-leaf"><i class="fas fa-spray-can me-2"></i>Manejo:</h5>
                                    <ul class="pest-solution-list">
                                        <li><strong>Cultural:</strong> Eliminar hojas afectadas</li>
                                        <li><strong>Biológico:</strong> Avispas parasitoides</li>
                                        <li><strong>Químico:</strong> Spinosad (solo en infestaciones severas)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pestaña de Enfermedades -->
            <div class="tab-pane fade" id="enfermedades" role="tabpanel">
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <!-- Enfermedad 1 -->
                    <div class="col">
                        <div class="card pest-card h-100">
                            <div class="pest-img-container">
                                <img src="{{ asset('images/pulgones.jpg') }}" class="card-img-top pest-img" alt="Mildiu">
                                <span class="pest-danger-level bg-danger">Alta peligrosidad</span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title pest-title">Mildiu velloso</h3>
                                <div class="pest-meta mb-3">
                                    <span class="badge bg-info me-2"><i class="fas fa-cloud-rain me-1"></i> Humedad alta</span>
                                    <span class="badge bg-danger"><i class="fas fa-skull-crossbones me-1"></i> Pérdidas graves</span>
                                </div>
                                <p class="card-text">Enfermedad fúngica que se desarrolla en condiciones de alta humedad y temperaturas frescas.</p>
                                
                                <div class="pest-symptoms mb-3">
                                    <h5 class="text-leaf"><i class="fas fa-eye me-2"></i>Síntomas:</h5>
                                    <ul>
                                        <li>Manchas amarillas en haz de hojas</li>
                                        <li>Mohos blancos/grisáceos en envés</li>
                                        <li>Necrosis y colapso de la planta</li>
                                    </ul>
                                </div>
                                
                                <div class="pest-solution">
                                    <h5 class="text-leaf"><i class="fas fa-spray-can me-2"></i>Manejo:</h5>
                                    <ul class="pest-solution-list">
                                        <li><strong>Preventivo:</strong> Buen drenaje, espaciamiento adecuado</li>
                                        <li><strong>Cultural:</strong> Rotación de cultivos</li>
                                        <li><strong>Químico:</strong> Fungicidas cúpricos</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enfermedad 2 -->
                    <div class="col">
                        <div class="card pest-card h-100">
                            <div class="pest-img-container">
                                <img src="{{ asset('images/minador.jpg') }}" class="card-img-top pest-img" alt="Pythium">
                                <span class="pest-danger-level bg-danger">Alta peligrosidad</span>
                            </div>
                            <div class="card-body">
                                <h3 class="card-title pest-title">Pudrición por Pythium</h3>
                                <div class="pest-meta mb-3">
                                    <span class="badge bg-info me-2"><i class="fas fa-tint me-1"></i> Exceso de agua</span>
                                    <span class="badge bg-danger"><i class="fas fa-skull-crossbones me-1"></i> Muerte plántulas</span>
                                </div>
                                <p class="card-text">Hongo de suelo que afecta raíces y base del tallo, especialmente en plántulas y plantas jóvenes.</p>
                                
                                <div class="pest-symptoms mb-3">
                                    <h5 class="text-leaf"><i class="fas fa-eye me-2"></i>Síntomas:</h5>
                                    <ul>
                                        <li>Marchitez repentina</li>
                                        <li>Tallos blandos y acuosos en la base</li>
                                        <li>Raíces oscuras y podridas</li>
                                    </ul>
                                </div>
                                
                                <div class="pest-solution">
                                    <h5 class="text-leaf"><i class="fas fa-spray-can me-2"></i>Manejo:</h5>
                                    <ul class="pest-solution-list">
                                        <li><strong>Preventivo:</strong> Sustratos bien drenados</li>
                                        <li><strong>Cultural:</strong> Evitar exceso de riego</li>
                                        <li><strong>Biológico:</strong> Trichoderma spp.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pestaña de Prevención -->
            <div class="tab-pane fade" id="prevencion" role="tabpanel">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="card prevention-card h-100">
                            <div class="card-body">
                                <h3 class="prevention-title text-center"><i class="fas fa-seedling me-2"></i>Prácticas Preventivas</h3>
                                <ul class="prevention-list">
                                    <li>
                                        <h5 class="text-leaf"><i class="fas fa-rotate me-2"></i>Rotación de cultivos</h5>
                                        <p>Alternar con cultivos no susceptibles (ej. maíz, frijol) por 2-3 años.</p>
                                    </li>
                                    <li>
                                        <h5 class="text-leaf"><i class="fas fa-ruler-combined me-2"></i>Distanciamiento adecuado</h5>
                                        <p>30-40 cm entre plantas para permitir circulación de aire.</p>
                                    </li>
                                    <li>
                                        <h5 class="text-leaf"><i class="fas fa-tint-slash me-2"></i>Manejo de riego</h5>
                                        <p>Regar por la mañana y evitar mojar follaje.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="card prevention-card h-100">
                            <div class="card-body">
                                <h3 class="prevention-title text-center"><i class="fas fa-biohazard me-2"></i>Control Biológico</h3>
                                <ul class="prevention-list">
                                    <li>
                                        <h5 class="text-leaf"><i class="fas fa-spider me-2"></i>Depredadores naturales</h5>
                                        <p>Introducir crisopas (Chrysoperla) para control de pulgones.</p>
                                    </li>
                                    <li>
                                        <h5 class="text-leaf"><i class="fas fa-virus me-2"></i>Microorganismos benéficos</h5>
                                        <p>Aplicar Bacillus subtilis para prevención de hongos.</p>
                                    </li>
                                    <li>
                                        <h5 class="text-leaf"><i class="fas fa-prescription-bottle-alt me-2"></i>Extractos vegetales</h5>
                                        <p>Preparados de ajo y chile como repelentes.</p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card calendar-card">
                    <div class="card-header bg-primary-green text-white">
                        <h4 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Calendario de Monitoreo</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered prevention-table">
                                <thead class="bg-light-green text-white">
                                    <tr>
                                        <th>Actividad</th>
                                        <th>Frecuencia</th>
                                        <th>Época Crítica</th>
                                        <th>Método</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Inspección de plagas</td>
                                        <td>Semanal</td>
                                        <td>Temporada seca</td>
                                        <td>Revisión visual de envés</td>
                                    </tr>
                                    <tr>
                                        <td>Monitoreo hongos</td>
                                        <td>2 veces/semana</td>
                                        <td>Época lluviosa</td>
                                        <td>Trampas adhesivas</td>
                                    </tr>
                                    <tr>
                                        <td>Análisis de suelo</td>
                                        <td>Anual</td>
                                        <td>Pre-siembra</td>
                                        <td>Muestreo aleatorio</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection