@extends('layout')

@section('title', $titulo)

@section('contenido')
<div class="container py-5">
    <h2 class="mb-4">{{ $titulo }}</h2>

    <div class="mb-3 text-end">
        <a href="#" onclick="window.print()" class="btn btn-success">
            <i class="fas fa-download me-2"></i>Descargar / Imprimir
        </a>
        <a href="{{ route('reportes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>

    <iframe src="data:application/pdf;base64,{{ $pdfContent }}" 
            width="100%" height="800px" style="border: none;"></iframe>
</div>
@endsection
