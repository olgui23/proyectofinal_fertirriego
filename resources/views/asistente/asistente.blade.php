@extends('layout')

@section('title', 'Proceso de Producción')

@section('contenido')
<div class="container py-5">
    <!-- Contenedor principal -->
    <div class="main-content-container">

        <!-- Encabezado -->
        <div class="text-center mb-5">
            <h1 class="plagas-title">NUESTRO PROCESO DE PRODUCCIÓN</h1>
            <p class="calendar-subtitle">Desde la preparación del suelo hasta la entrega fresca en tu mesa</p>
        </div>

        <!-- Sección: Del campo a tu mesa -->
        <div class="practice-section mb-5">
            <div class="practice-header bg-primary-green text-white">
                <h3><i class="fas fa-seedling me-2"></i>Del Campo a tu Mesa</h3>
            </div>

            <div class="practice-body">
                <div class="row">

                    <!-- Paso 1 -->
                    <div class="col-md-6 mb-4">
                        <div class="practice-card h-100">
                            <div class="practice-img-container">
                                <img src="{{ asset('images/suelo.jpg') }}" alt="Preparación del suelo" class="practice-img">
                            </div>
                            <div class="practice-content">
                                <h4 class="practice-title">1. Preparación del Suelo</h4>
                                <ul class="practice-list">
                                    <li>Uso de compost orgánico y nutrientes naturales</li>
                                    <li>Análisis del pH y estructura del suelo</li>
                                    <li>Labranza suave para proteger la microbiota</li>
                                    <li>Nivelación para evitar encharcamientos</li>
                                </ul>
                                <div class="practice-tip bg-leaf text-white">
                                    <i class="fas fa-lightbulb me-2"></i>Utilizamos compost elaborado en nuestro propio vivero.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 2 -->
                    <div class="col-md-6 mb-4">
                        <div class="practice-card h-100">
                            <div class="practice-img-container">
                                <img src="{{ asset('images/siembra.jpg') }}" alt="Siembra orgánica" class="practice-img">
                            </div>
                            <div class="practice-content">
                                <h4 class="practice-title">2. Siembra Selectiva</h4>
                                <ul class="practice-list">
                                    <li>Semillas orgánicas certificadas</li>
                                    <li>Siembra en el momento óptimo del año</li>
                                    <li>Respeto a los ciclos naturales del suelo</li>
                                    <li>Distribución equitativa para mejorar el crecimiento</li>
                                </ul>
                                <div class="practice-tip bg-leaf text-white">
                                    <i class="fas fa-leaf me-2"></i>Sembramos en función del calendario lunar agrícola.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 3 -->
                    <div class="col-md-6 mb-4">
                        <div class="practice-card h-100">
                            <div class="practice-img-container">
                                <img src="{{ asset('images/riego_inteligente.jpg') }}" alt="Riego inteligente" class="practice-img">
                            </div>
                            <div class="practice-content">
                                <h4 class="practice-title">3. Riego Inteligente</h4>
                                <ul class="practice-list">
                                    <li>Sistema por goteo que optimiza el uso del agua</li>
                                    <li>Monitoreo constante de la humedad del suelo</li>
                                    <li>Ajuste automático de caudal según la necesidad</li>
                                    <li>Reducción del desperdicio de agua hasta 90%</li>
                                </ul>
                                <div class="practice-tip bg-leaf text-white">
                                    <i class="fas fa-tint me-2"></i>En Tiquipaya utilizamos agua de captación de lluvia tratada.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 4 -->
                    <div class="col-md-6 mb-4">
                        <div class="practice-card h-100">
                            <div class="practice-img-container">
                                <img src="{{ asset('images/cuidado_organico.jpg') }}" alt="Cuidado orgánico" class="practice-img">
                            </div>
                            <div class="practice-content">
                                <h4 class="practice-title">4. Cuidado Orgánico</h4>
                                <ul class="practice-list">
                                    <li>Control natural de plagas con métodos biológicos</li>
                                    <li>Rotación de cultivos para mantener la fertilidad</li>
                                    <li>Fertilización con compost orgánico</li>
                                    <li>Conservación de la biodiversidad del entorno</li>
                                </ul>
                                <div class="practice-tip bg-leaf text-white">
                                    <i class="fas fa-bug me-2"></i>Usamos extractos naturales como neem y ajo para el control de plagas.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 5 -->
                    <div class="col-md-6 mb-4">
                        <div class="practice-card h-100">
                            <div class="practice-img-container">
                                <img src="{{ asset('images/cosecha.jpg') }}" alt="Cosecha manual" class="practice-img">
                            </div>
                            <div class="practice-content">
                                <h4 class="practice-title">5. Cosecha Manual</h4>
                                <ul class="practice-list">
                                    <li>Recolectamos en el punto óptimo de maduración</li>
                                    <li>Selección cuidadosa de cada hortaliza</li>
                                    <li>Manipulación mínima para evitar daños</li>
                                    <li>Control de calidad antes del empaque</li>
                                </ul>
                                <div class="practice-tip bg-leaf text-white">
                                    <i class="fas fa-hands me-2"></i>La cosecha se realiza al amanecer para conservar la frescura.
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Paso 6 -->
                    <div class="col-md-6 mb-4">
                        <div class="practice-card h-100">
                            <div class="practice-img-container">
                                <img src="{{ asset('images/entrega_fresca.jpg') }}" alt="Entrega fresca" class="practice-img">
                            </div>
                            <div class="practice-content">
                                <h4 class="practice-title">6. Entrega Fresca</h4>
                                <ul class="practice-list">
                                    <li>Empaque inmediato tras la cosecha</li>
                                    <li>Transporte refrigerado y limpio</li>
                                    <li>Entrega el mismo día para máxima frescura</li>
                                    <li>Garantía de cadena de frío</li>
                                </ul>
                                <div class="practice-tip bg-leaf text-white">
                                    <i class="fas fa-truck me-2"></i>Entregamos directamente a mercados locales de Tiquipaya.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección: Métodos de cultivo -->
        <div class="practice-section">
            <div class="practice-header bg-primary-green text-white">
                <h3><i class="fas fa-leaf me-2"></i>Nuestros Métodos de Cultivo</h3>
            </div>

            <div class="practice-body">
                <div class="row">
                    <!-- Método 1 -->
                    <div class="col-md-4 mb-4">
                        <div class="eco-card h-100">
                            <div class="eco-icon bg-leaf"><i class="fas fa-tractor"></i></div>
                            <h4 class="eco-title">Agricultura Orgánica</h4>
                            <ul class="eco-list">
                                <li>Libre de pesticidas sintéticos</li>
                                <li>Compostaje natural</li>
                                <li>Control biológico de plagas</li>
                                <li>Rotación y biodiversidad</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Método 2 -->
                    <div class="col-md-4 mb-4">
                        <div class="eco-card h-100">
                            <div class="eco-icon bg-leaf"><i class="fas fa-water"></i></div>
                            <h4 class="eco-title">Riego Sostenible</h4>
                            <ul class="eco-list">
                                <li>Uso eficiente del agua (hasta 90% menos)</li>
                                <li>Control automático de humedad</li>
                                <li>Reutilización de aguas pluviales</li>
                                <li>Optimización por sensores</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Método 3 -->
                    <div class="col-md-4 mb-4">
                        <div class="eco-card h-100">
                            <div class="eco-icon bg-leaf"><i class="fas fa-sun"></i></div>
                            <h4 class="eco-title">Invernaderos Inteligentes</h4>
                            <ul class="eco-list">
                                <li>Control de temperatura y luz</li>
                                <li>Producción todo el año</li>
                                <li>Eficiencia energética</li>
                                <li>Protección natural contra plagas</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección final: Nuestro vivero -->
        <div class="text-center mt-5">
            <h2 class="plagas-title">NUESTRO VIVERO</h2>
            <p class="calendar-subtitle mb-4">El corazón de nuestra producción orgánica</p>
            <img src="{{ asset('images/vivero.jpg') }}" alt="Nuestro vivero" class="img-fluid rounded shadow-lg" style="max-width: 80%; border: 5px solid #64A500;">
        </div>

    </div>
</div>
@endsection
