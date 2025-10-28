@extends('layout')

@section('title', 'Inicio - Panel del Comprador')

@section('cabecera')

    <header id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('{{ asset("images/lechuga3.jpeg") }}'); background-size: cover; background-position: center; height: 100vh;">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 bg-dark bg-opacity-50 rounded">
                    <h1 class="display-4 fw-bold text-white">Lechuga Bebé</h1>
                    <p class="lead text-white">Bs. 15,00.-</p>
                    <a class="btn btn-success btn-lg mt-3" href="#impacto">Haz tu pedido</a>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset("images/lechuga4.jpeg") }}'); background-size: cover; background-position: center; height: 100vh;">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 bg-dark bg-opacity-50 rounded">
                    <h1 class="display-4 fw-bold text-white">Lechuga Crespa</h1>
                    <p class="lead text-white">Bs. 12,50.-</p>
                    <a class="btn btn-success btn-lg mt-3" href="{{ route('productos.index') }}">Haz tu pedido</a>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset('images/lechuga5.jpeg') }}'); background-size: cover; background-position: center; height: 100vh;">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 bg-dark bg-opacity-50 rounded">
                    <h1 class="display-4 fw-bold text-white">Lechuga Morada</h1>
                    <p class="lead text-white">Bs. 13,00.-</p>
                    <a class="btn btn-success btn-lg mt-3" href="{{ route('productos.index') }}">Haz tu pedido</a>
                </div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset('images/lechuga6.jpeg') }}'); background-size: cover; background-position: center; height: 100vh;">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100 bg-dark bg-opacity-50 rounded">
                    <h1 class="display-4 fw-bold text-white">Lechuga Romana</h1>
                    <p class="lead text-white">Bs. 12,00.-</p>
                    <a class="btn btn-success btn-lg mt-3" href="{{ route('productos.index') }}">Hay tu pedido</a>
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


@endsection
