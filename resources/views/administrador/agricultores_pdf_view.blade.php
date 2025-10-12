@extends('layout')

@section('title', 'Vista previa PDF Agricultores')

@section('contenido')
<div class="container py-5">
    <h2 class="mb-4">Vista previa PDF: Agricultores Registrados</h2>

    <div class="mb-3 text-end">
        <a href="{{ route('administrador.agricultores.pdf-download') }}" class="btn btn-success">
            <i class="fas fa-download me-2"></i>Descargar PDF
        </a>
        <a href="{{ url()->previous() }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Volver
        </a>
    </div>

    <div style="height: 80vh;">
        <iframe 
            src="data:application/pdf;base64,{{ $pdfContent }}" 
            frameborder="0" 
            style="width: 100%; height: 100%;"
        ></iframe>
    </div>
</div>
@endsection
