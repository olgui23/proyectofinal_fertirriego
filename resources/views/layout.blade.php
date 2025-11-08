<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Sistema de Fertirrigación para cultivo de lechuga en Tiquipaya" />
    <meta name="author" content="" />
    <title>@yield('title', 'Fertirriego')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('images/logoFertirriego.png') }}" />

    <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Merriweather:wght@700&display=swap" rel="stylesheet">
    <!-- Google Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>


    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Bootstrap & Theme CSS -->
    <link href="{{ asset('startbootstrap-agency-gh-pages/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet" />
    
    
</head>
<body id="page-top">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center me-auto" href="#page-top">
            <img src="{{ asset('images/logoFertirriego.png') }}" alt="Logo" style="height: 32px; margin-right: 10px;">
            <span class="fw-bold text-uppercase fs-5" style="color: #64A500;">Fertirrigación</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
                    aria-label="Toggle navigation">
                Menú <i class="fas fa-bars ms-1"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <!-- <li class="nav-item"><a class="nav-link" href="{{ route('dashboard') }}">Inicio</a></li> -->
                    <!-- Barra superior de navegación con login/register -->
@if (Route::has('login'))
    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-50">
        <ul class="nav justify-content-end">
            @auth
               
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
@endif


                    <!-- Menú según rol -->
                     @auth
                        @if(Auth::user()->rol === 'administrador')
                        <!-- Menú para Administrador -->
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Inicio</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('administrador.index') }}">Registrar</a></li>
                          <!--  <li class="nav-item"><a class="nav-link" href="#">Cultivos</a></li> -->
                            <li class="nav-item"><a class="nav-link" href="{{ route('equipos.index') }}">Equipos</a></li>
                           <!-- <li class="nav-item"><a class="nav-link" href="{{ route('reportes') }}">Reportes</a></li> -->
                        @elseif(Auth::user()->rol === 'agricultor')
                        <!-- Menú para Agricultor -->
                            <li class="nav-item"><a class="nav-link" href="{{ route('farm.dashboard') }}">Inicio</a></li>
                           <li class="nav-item"><a class="nav-link" href="{{ route('reporte_equipos.index') }}">Control del Cultivo</a>
</li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="cultivoDropdown" role="button" data-bs-toggle="dropdown">
                                    Mi Cultivo
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('miCultivo.reportes') }}">Reportes</a></li>
                                    <li><a class="dropdown-item" href="{{ route('miCultivo.calendario') }}">Calendario</a></li>
                                </ul>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="guiaDropdown" role="button" data-bs-toggle="dropdown">
                                    Tu Guía
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('guia.variedades') }}">Tipos de lechuga</a></li>
                                    <li><a class="dropdown-item" href="{{ route('guia.plagas') }}">Plagas & Enfermedades</a></li>
                                    <li><a class="dropdown-item" href="{{ route('guia.salud') }}">Salud vegetal</a></li>
                                    <li><a class="dropdown-item" href="{{ route('guia.practicas') }}">Buenas prácticas</a></li>
                                </ul>
                            </li>
                            <!-- NUEVO: Productos -->
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="productosDropdown" role="button" data-bs-toggle="dropdown">
                                 Productos
                                </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="{{ route('productos.index') }}">Mis Productos</a></li>
                                        <li><a class="dropdown-item" href="{{ route('productos.crear') }}">Agregar Producto</a></li>
                                        <li><a class="dropdown-item" href="{{ route('productos.agricultor') }}">Administración</a></li>
                                        <li><a class="dropdown-item" href="{{ route('ventas.index') }}">Ventas</a></li>
                                    </ul>
                            </li>
                        @elseif(Auth::user()->rol === 'comprador')
                        <!-- Menú para Comprador -->
                            <li class="nav-item"><a class="nav-link" href="{{ route('buyer.dashboard') }}">Inicio</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('asistente') }}">Cómo Cultivamos</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('productos.index') }}">Productos</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('ventas.miscompras') }}">Mis compras</a></li>
                        @endif
                    @endauth

                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <small class="text-muted small"><i class="fas fa-user-circle me-1"></i> {{ Auth::user()->nombre }} ({{ Auth::user()->rol }})</small>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('perfil.edit') }}"><i class="fas fa-user me-1"></i> Mi Perfil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-1"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Carrusel principal -->
    <header>
        @yield('cabecera')
    </header>

    <!-- Contenido dinámico -->
    <main>
        @yield('contenido')
    </main>

    <!-- Footer -->
    <footer class="footer py-4 bg-dark text-white">
        <div class="container">
            <div class="row align-items-center text-center">
                <div class="col-lg-4 text-lg-start">Copyright &copy; Fertirriego {{ date('Y') }}</div>
                <div class="col-lg-4 my-3 my-lg-0">
                    <a class="btn btn-outline-light btn-social mx-2" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social mx-2" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social mx-2" href="#"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a class="link-light text-decoration-none me-3" href="#">Política de Privacidad</a>
                    <a class="link-light text-decoration-none" href="#">Términos de Uso</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('startbootstrap-agency-gh-pages/js/scripts.js') }}"></script>
@stack('scripts')
</body>
</html>