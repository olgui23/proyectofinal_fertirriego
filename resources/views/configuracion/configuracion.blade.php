@extends('layout')

@section('title', 'Configuración')

@section('contenido')
<section class="page-section clearfix">
    <div class="container">
        <h2 class="text-center text-success">Parámetros del Sistema</h2>
        <table class="table table-bordered bg-white">
            <thead><tr><th>Parámetro</th><th>Valor</th><th>Descripción</th></tr></thead>
            <tbody>
                @foreach($configuraciones as $c)
                <tr>
                    <td>{{ $c->parametro }}</td>
                    <td>{{ $c->valor }}</td>
                    <td>{{ $c->descripcion }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
