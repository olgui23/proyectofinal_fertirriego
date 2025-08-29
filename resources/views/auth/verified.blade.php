@extends('layout')

@section('title', 'Email Verificado')

@section('contenido')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0 text-center">¡Email Verificado Exitosamente!</h5>
                </div>

                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle fa-5x text-success"></i>
                    </div>
                    
                    <h4>¡Felicidades!</h4>
                    <p class="mb-4">Tu dirección de email ha sido verificada correctamente.</p>

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">
                            Ir al Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                            Iniciar Sesión
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection