@extends('layout')

@section('title', 'Inicio - Panel del Agricultor')
@section('cabecera')

    <header id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('{{ asset("images/slide1.jpg") }}'); background-size: cover; background-position: center; height: 100vh;">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 bg-dark bg-opacity-50 rounded">
                    <h1 class="display-4 fw-bold text-white">Tecnología al servicio del campo</h1>
                    <p class="lead text-white">Soluciones sostenibles para agricultores de Tiquipaya</p>
                    <a class="btn btn-success btn-lg mt-3" href="#impacto">Conoce más</a>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset("images/slide2.jpg") }}'); background-size: cover; background-position: center; height: 100vh;">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 bg-dark bg-opacity-50 rounded">
                    <h1 class="display-4 fw-bold text-white">Riego automatizado</h1>
                    <p class="lead text-white">Ahorra agua, tiempo y fertilizantes</p>
                    <a class="btn btn-success btn-lg mt-3" href="#impacto">Descúbrelo</a>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset('images/slide3.jpg') }}'); background-size: cover; background-position: center; height: 100vh;">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 bg-dark bg-opacity-50 rounded">
                    <h1 class="display-4 fw-bold text-white">Agricultura con futuro</h1>
                    <p class="lead text-white">Conecta tu campo con tecnología accesible</p>
                    <a class="btn btn-success btn-lg mt-3" href="#impacto">Ver sistema</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>
    </header>


@endsection

@section('contenido')

    <!-- Sección imagen circular y texto al lado -->
    <section class="py-5" id="impacto" style="background: linear-gradient(to right, #f4fdf1, #ffffff);">
        <div class="container d-flex align-items-center justify-content-between flex-wrap">
            <div class="col-md-6">
                <h1 class="fw-bold">Haz un impacto 🌱<br><span style="color: #64A500;">Devuélvele vida a la tierra</span></h1>
                <p class="mt-3">Nuestro sistema automatizado ayuda a agricultores de Tiquipaya a cultivar de forma eficiente, saludable y sostenible, monitoreando en tiempo real la humedad del suelo y controlando el riego con sensores inteligentes.</p>
                <a href="#beneficios" class="btn btn-primary mt-3">Conoce más</a>
            </div>
            <div class="col-md-5 text-center">
                <img src="{{ asset('images/hero_plants.jpg') }}" alt="Plantas saludables"
        class="rounded-circle border shadow-lg"
        style="width: 420px; height: 420px; object-fit: cover; border: 6px solid #64A500;">
            </div>
        </div>
    </section>

    <!-- Sección de beneficios -->
    <section id="beneficios" class="py-5 text-center">
        <div class="container">
            <h2 class="text-uppercase mb-4" style="color: #64A500;">Beneficios del Sistema</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <i class="fas fa-leaf fa-3x mb-2" style="color: #64A500;"></i>
                    <h5 class="fw-bold">Cultivo más saludable</h5>
                    <p>Monitoreo y riego adecuados según las necesidades del cultivo de lechuga.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fas fa-tint fa-3x mb-2" style="color: #64A500;"></i>
                    <h5 class="fw-bold">Ahorro de recursos</h5>
                    <p>Optimización automática del uso de agua y fertilizantes.</p>
                </div>
                <div class="col-md-4 mb-4">
                    <i class="fas fa-chart-line fa-3x mb-2" style="color: #64A500;"></i>
                    <h5 class="fw-bold">Decisiones inteligentes</h5>
                    <p>Informes visuales para mejorar tu producción día a día.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección tipo tarjetas (cuadros informativos) -->
    <section class="py-5 bg-white text-center">
        <div class="container">
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card h-100 text-white" style="background-color: #64A500;">
                        <div class="card-body">
                            <h5 class="card-title">Automatización</h5>
                            <p class="card-text">Sensores que activan el riego automáticamente cuando se necesita.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 text-white" style="background-color: #64A500;">
                        <div class="card-body">
                            <h5 class="card-title">Tecnología local</h5>
                            <p class="card-text">Diseñado con software libre y pensando en la realidad de Tiquipaya.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 text-white" style="background-color: #64A500;">
                        <div class="card-body">
                            <h5 class="card-title">Sostenibilidad</h5>
                            <p class="card-text">Reducimos el impacto ambiental y mejoramos la producción.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 text-white" style="background-color: #64A500;">
                        <div class="card-body">
                            <h5 class="card-title">Accesibilidad</h5>
                            <p class="card-text">Agricultores con poca experiencia tecnológica pueden usarlo fácilmente.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection