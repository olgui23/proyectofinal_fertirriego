@extends('layout')

@section('title', 'Reportes del Sistema')

@section('contenido')
<div class="container py-5">
    <h2 class="text-success mb-4">📊 Panel de Reportes</h2>

    <div class="list-group">
        <a href="{{ route('reportes.agricultores') }}" class="list-group-item list-group-item-action">
            👨‍🌾 Reporte de Agricultores
        </a>
        <a href="{{ route('reportes.equipos') }}" class="list-group-item list-group-item-action">
            ⚙️ Reporte de Equipos
        </a>
        <a href="{{ route('reportes.ventas') }}" class="list-group-item list-group-item-action">
            💰 Reporte de Ventas
        </a>
    </div>
</div>
@endsection
