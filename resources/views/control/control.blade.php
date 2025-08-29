@extends('layout')

@section('title', 'Sensores')

@section('contenido')
<section class="page-section clearfix py-5">
    <div class="container">
        <h2 class="text-center text-success mb-4">Sensores</h2>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">
                <div class="ratio ratio-16x9 shadow rounded-4 overflow-hidden">
                    <iframe 
                        src="http://192.168.180.173"
                        width="100%" 
                        height="700" 
                        style="border: none;">
                    </iframe>
                </div>

                <div class="text-center mt-4">
                    <a href="#impacto" class="btn btn-impacto btn-lg me-2">Ver impacto</a>
                    <a href="/" class="btn btn-impacto btn-lg">Inicio</a>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection
