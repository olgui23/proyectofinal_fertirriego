@extends('layout')

@section('title', 'Visualización PDF de Equipos')

@section('contenido')
<div class="container my-5">
    <h2 class="text-center text-success mb-4">📋 Equipos registrados</h2>

    <div class="text-end mb-3">
        <a href="{{ route('equipos.pdf-download') }}" class="btn btn-success">
            <i class="fas fa-download me-2"></i>Descargar PDF
        </a>
    </div>

    <iframe src="data:application/pdf;base64,{{ $pdfContent }}" width="100%" height="800px" style="border: none;"></iframe>
</div>
@endsection
