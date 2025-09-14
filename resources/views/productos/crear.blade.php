@extends('layout')

@section('title', 'Agregar Producto')

@section('contenido')
<div class="container my-5">
    <h2 class="mb-4">Agregar nuevo producto</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('productos.guardar') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nombre *</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Imagen</label>
            <input type="file" name="image_url" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción *</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Precio *</label>
                <input type="number" step="0.01" name="precio" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Unidad *</label>
                <input type="text" name="unidad" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Stock *</label>
                <input type="number" name="stock" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Origen</label>
            <input type="text" name="origen" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Beneficios</label>
            <textarea name="beneficios" class="form-control"></textarea>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="disponible" class="form-check-input" value="1" checked>
            <label class="form-check-label">Disponible</label>
        </div>

        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
