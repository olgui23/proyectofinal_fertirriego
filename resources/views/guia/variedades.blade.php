@extends('layout')

@section('title', 'Variedades de Lechuga')

@section('contenido')
<div class="container py-5">
    <!-- Contenedor principal con sombra -->
    <div class="main-content-container">
        <!-- Encabezado -->
        <div class="text-center mb-5">
            <h1 class="calendar-title">VARIEDADES DE LECHUGA</h1>
            <p class="calendar-subtitle">Descubre las diferentes variedades y sus características</p>
        </div>

        <!-- Sección de variedades -->
        <div class="row row-cols-1 row-cols-md-2 g-4">
            <!-- Variedad 1 -->
            <div class="col">
                <div class="card variety-card h-100">
                    <div class="variety-img-container">
                        <img src="{{ asset('images/romana.png') }}" class="card-img-top variety-img" alt="Lechuga Romana">
                        <span class="variety-badge bg-primary-green">Más popular</span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title variety-title">Romana</h3>
                        <div class="variety-meta mb-3">
                            <span class="badge bg-light-green me-2">🌱 50-70 días</span>
                            <span class="badge bg-light-green">🌡️ 15-20°C</span>
                        </div>
                        <p class="card-text">Hojas alargadas y erguidas con nervadura central pronunciada. Textura crujiente y sabor ligeramente amargo.</p>
                        <ul class="variety-features">
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Alto contenido en vitaminas A y K</li>
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Resistente al calor</li>
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Ideal para ensaladas César</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Variedad 2 -->
            <div class="col">
                <div class="card variety-card h-100">
                    <div class="variety-img-container">
                        <img src="{{ asset('images/mantequilla.jpg') }}" class="card-img-top variety-img" alt="Lechuga Mantequilla">
                    </div>
                    <div class="card-body">
                        <h3 class="card-title variety-title">Mantequilla</h3>
                        <div class="variety-meta mb-3">
                            <span class="badge bg-light-green me-2">🌱 45-60 días</span>
                            <span class="badge bg-light-green">🌡️ 10-18°C</span>
                        </div>
                        <p class="card-text">Hojas suaves, tiernas y de textura mantecosa. Forma de cabeza suelta y sabor delicado y dulce.</p>
                        <ul class="variety-features">
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Alta sensibilidad a temperaturas extremas</li>
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Requiere suelos bien drenados</li>
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Perfecta para ensaladas delicadas</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Variedad 3 -->
            <div class="col">
                <div class="card variety-card h-100">
                    <div class="variety-img-container">
                        <img src="{{ asset('images/crespa.png') }}" class="card-img-top variety-img" alt="Lechuga Crespa">
                        <span class="variety-badge bg-dark-green">Resistente</span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-title variety-title">Crespa</h3>
                        <div class="variety-meta mb-3">
                            <span class="badge bg-light-green me-2">🌱 55-75 días</span>
                            <span class="badge bg-light-green">🌡️ 12-22°C</span>
                        </div>
                        <p class="card-text">Hojas rizadas y crujientes con bordes ondulados. Color verde intenso y sabor fresco con toques herbáceos.</p>
                        <ul class="variety-features">
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Alta resistencia a plagas</li>
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Tolerancia media a la sequía</li>
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Excelente para mezclas de ensalada</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Variedad 4 -->
            <div class="col">
                <div class="card variety-card h-100">
                    <div class="variety-img-container">
                        <img src="{{ asset('images/iceberg.png') }}" class="card-img-top variety-img" alt="Lechuga Iceberg">
                    </div>
                    <div class="card-body">
                        <h3 class="card-title variety-title">Iceberg</h3>
                        <div class="variety-meta mb-3">
                            <span class="badge bg-light-green me-2">🌱 70-90 días</span>
                            <span class="badge bg-light-green">🌡️ 16-24°C</span>
                        </div>
                        <p class="card-text">Cabezas compactas y firmes con hojas crujientes y acuosas. Sabor suave y textura refrescante.</p>
                        <ul class="variety-features">
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Larga vida postcosecha</li>
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Requiere riego constante</li>
                            <li><i class="fas fa-check-circle text-leaf me-2"></i>Ideal para sandwiches y wraps</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla comparativa -->
        <div class="mt-5">
            <h3 class="variety-compare-title text-center mb-4">
                <i class="fas fa-table text-leaf me-2"></i>Comparativa de Variedades
            </h3>
            <div class="table-responsive">
                <table class="table table-bordered variety-table">
                    <thead class="bg-primary-green text-white">
                        <tr>
                            <th>Variedad</th>
                            <th>Ciclo (días)</th>
                            <th>Temperatura</th>
                            <th>Resistencia</th>
                            <th>Uso Ideal</th>
                            <th>Contenido Nutricional</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Romana</strong></td>
                            <td>50-70</td>
                            <td>15-20°C</td>
                            <td>Alta</td>
                            <td>Ensaladas, grill</td>
                            <td>Alta en A, K</td>
                        </tr>
                        <tr>
                            <td><strong>Mantequilla</strong></td>
                            <td>45-60</td>
                            <td>10-18°C</td>
                            <td>Media</td>
                            <td>Ensaladas delicadas</td>
                            <td>Rica en folatos</td>
                        </tr>
                        <tr>
                            <td><strong>Crespa</strong></td>
                            <td>55-75</td>
                            <td>12-22°C</td>
                            <td>Alta</td>
                            <td>Mezclas, decoración</td>
                            <td>Vitamina C</td>
                        </tr>
                        <tr>
                            <td><strong>Iceberg</strong></td>
                            <td>70-90</td>
                            <td>16-24°C</td>
                            <td>Media</td>
                            <td>Sandwiches, wraps</td>
                            <td>Hidratación</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection