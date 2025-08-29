@extends('layout')

@section('title', 'Inicio - Fertirriego')

@section('contenido')

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
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('images/noticia1.jpg') }}" class="card-img-top" alt="Noticia 1">
                    <div class="card-body">
                        <h5 class="card-title">Nueva actualización de sensores</h5>
                        <p class="card-text">Ahora puedes ver lecturas más precisas en tu panel de control.</p>
                        <a href="#" class="btn btn-outline-success btn-sm">Leer más</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('images/noticia2.jpg') }}" class="card-img-top" alt="Noticia 2">
                    <div class="card-body">
                        <h5 class="card-title">Visita técnica a Tiquipaya</h5>
                        <p class="card-text">Conectamos con agricultores para mejorar la implementación del sistema.</p>
                        <a href="#" class="btn btn-outline-success btn-sm">Leer más</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('images/noticia3.jpg') }}" class="card-img-top" alt="Noticia 3">
                    <div class="card-body">
                        <h5 class="card-title">Capacitación comunitaria</h5>
                        <p class="card-text">Más de 30 productores participaron en talleres sobre fertirrigación.</p>
                        <a href="#" class="btn btn-outline-success btn-sm">Leer más</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
