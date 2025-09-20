@extends('layout')

@section('title', 'Agregar Producto')

@section('contenido')
<div class="container my-6">
    <div class="form-container d-flex flex-column flex-lg-row shadow-sm" style="background: white; border-radius: 15px; overflow: hidden;">
        <!-- Columna izquierda con imagen -->
        <div class="col-lg-5 p-0 d-flex align-items-center justify-content-center bg-white">
            <img src="{{ asset('images/logofertirriego.png') }}" alt="Logo Fertirriego" class="img-fluid p-4" style="max-height: 400px;">
        </div>
        
        <!-- Columna derecha con formulario -->
        <div class="col-lg-7 p-4 p-md-5">
            <h2 class="mb-4" style="color: #64A500; font-family: 'Merriweather', serif; font-weight: 700;">Agregar nuevo producto</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('productos.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="nombre" class="form-control" required style="border-radius: 8px; border: 2px solid #e1e8e1;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen</label>
                    <input type="file" name="image_url" class="form-control" style="border-radius: 8px; border: 2px solid #e1e8e1;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción *</label>
                    <textarea name="descripcion" class="form-control" required style="border-radius: 8px; border: 2px solid #e1e8e1;"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio *</label>
                        <input type="number" step="0.01" name="precio" class="form-control" required style="border-radius: 8px; border: 2px solid #e1e8e1;">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Unidad *</label>
                        <select name="unidad" class="form-select" required style="border-radius: 8px; border: 2px solid #e1e8e1;">
                            <option value="">Seleccione una opción</option>
                            <option value="Kg">Kg</option>
                            <option value="Manojo">Manojo</option>
                            <option value="Bolsa">Bolsa</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stock *</label>
                        <input type="number" name="stock" class="form-control" required style="border-radius: 8px; border: 2px solid #e1e8e1;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Origen</label>
                    <input type="text" name="origen" class="form-control" style="border-radius: 8px; border: 2px solid #e1e8e1;">
                </div>

                <div class="mb-3">
                    <label class="form-label">Beneficios</label>
                    <textarea name="beneficios" class="form-control" style="border-radius: 8px; border: 2px solid #e1e8e1;"></textarea>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="disponible" class="form-check-input" value="1" checked style="border: 2px solid #e1e8e1;">
                    <label class="form-check-label">Disponible</label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-impacto flex-grow-1">Guardar</button>
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary" style="border-radius: 8px; padding: 10px 25px;">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .form-control:focus, .form-select:focus {
        border-color: #64A500 !important;
        box-shadow: 0 0 0 0.25rem rgba(100, 165, 0, 0.25);
    }
    
    .form-check-input:checked {
        background-color: #64A500;
        border-color: #64A500;
    }
    
    @media (max-width: 992px) {
        .form-container > div:first-child {
            display: none !important;
        }
    }
</style>
@endsection