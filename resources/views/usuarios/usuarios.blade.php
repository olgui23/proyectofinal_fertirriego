@extends('layout')

@section('title', 'Usuarios')

@section('contenido')
<section class="page-section clearfix">
    <div class="container">
        <h2 class="text-center text-success">Usuarios Registrados</h2>
        <table class="table table-bordered bg-white">
            <thead><tr><th>Nombre</th><th>Email</th><th>Rol</th></tr></thead>
            <tbody>
                @foreach($usuarios as $u)
                <tr>
                    <td>{{ $u->nombre }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->rol }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>
@endsection
