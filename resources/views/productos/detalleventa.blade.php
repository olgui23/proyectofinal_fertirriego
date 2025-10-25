@extends('layout')

@section('title', 'Detalle de Venta')

@section('contenido')
<div class="container py-4">
    @include('productos.detalleventa_modal') <!-- Reutilizamos el modal -->
</div>
@endsection
