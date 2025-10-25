@extends('layout')

@section('title', 'Inicio - Fertirriego')

@section('contenido')

<!-- Barra superior de navegación con login/register -->
@if (Route::has('login'))
    <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-50">
        @auth
            <a href="{{ url('/dashboard') }}"
               class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Inicio
            </a>
        @else
            <a href="{{ route('login') }}"
               class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Iniciar Sesión
            </a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                    Registrarse
                </a>
            @endif
        @endauth
    </div>
@endif


<!-- Sección imagen circular y texto al lado -->
<section class="py-5" id="impacto" style="background: linear-gradient(to right, #f4fdf1, #ffffff);">
    <div class="container d-flex align-items-center justify-content-between flex-wrap">
        <div class="col-md-6">
            <h1 class="fw-bold">Haz un impacto 🌱<br><span style="color: #64A500;">Devuélvele vida a la tierra</span></h1>
            <p class="mt-3">Nuestro sistema automatizado ayuda a agricultores de Tiquipaya a cultivar de forma eficiente, saludable y sostenible, monitoreando en tiempo real la humedad del suelo y controlando el riego con sensores inteligentes.</p>
            <a href="#beneficios" class="btn btn-success mt-3">Conoce más</a>
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

<!-- Sección tipo tarjetas -->
<section class="py-5 bg-white text-center">
    <div class="container">
        <div class="row">
            @php
                $cards = [
                    ['title' => 'Automatización', 'text' => 'Sensores que activan el riego automáticamente cuando se necesita.'],
                    ['title' => 'Tecnología local', 'text' => 'Diseñado con software libre y pensando en la realidad de Tiquipaya.'],
                    ['title' => 'Sostenibilidad', 'text' => 'Reducimos el impacto ambiental y mejoramos la producción.'],
                    ['title' => 'Accesibilidad', 'text' => 'Agricultores con poca experiencia tecnológica pueden usarlo fácilmente.']
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 text-white" style="background-color: #64A500;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $card['title'] }}</h5>
                            <p class="card-text">{{ $card['text'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Sección de misión -->
<section class="py-5 bg-light text-center">
    <div class="container">
        <h2 class="mb-4">Nuestra Misión</h2>
        <p class="lead">Promover una agricultura más inteligente, sostenible y accesible para todos los productores de lechuga en Tiquipaya mediante el uso de tecnologías innovadoras.</p>
    </div>
</section>

<!-- Noticias recientes -->
<section class="py-5 bg-white" id="noticias">
    <div class="container">
        <h2 class="text-center mb-5" style="color: #64A500;">Noticias Recientes</h2>
        <div class="row">
            @php
                $noticias = [
                    ['img' => 'apps.jpg', 'title' => 'Nueva actualización de sensores', 'desc' => 'Ahora puedes ver lecturas más precisas en tu panel de control.'],
                    ['img' => 'visita.jpg', 'title' => 'Visita técnica a Tiquipaya', 'desc' => 'Conectamos con agricultores para mejorar la implementación del sistema.'],
                    ['img' => 'visita2.jpg', 'title' => 'Capacitación comunitaria', 'desc' => 'Más de 30 productores participaron en talleres sobre fertirrigación.']
                ];
            @endphp

            @foreach ($noticias as $noticia)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('images/' . $noticia['img']) }}" class="card-img-top" alt="{{ $noticia['title'] }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $noticia['title'] }}</h5>
                            <p class="card-text">{{ $noticia['desc'] }}</p>
                            <a href="#" class="btn btn-outline-success btn-sm">Leer más</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
    </style>
</section>

@endsection
