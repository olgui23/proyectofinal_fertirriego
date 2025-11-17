@extends('layout')

@section('title', 'Agregar Producto')

@section('contenido')
<div class="container my-6">
    <div class="form-wrapper shadow-sm p-4 rounded-4" style="background: #f9fafc;">

        <!-- Encabezado bonito -->
        <div class="mb-4 text-center">
            <h2 style="color: #4C8C2B; font-family: 'Merriweather', serif; font-weight: 700;">Agregar nuevo producto</h2>
            <hr class="mx-auto" style="width: 80px; border: 2px solid #64A500; opacity: 0.6;">
        </div>

        <div class="row g-0 bg-white rounded-4 overflow-hidden shadow-sm">
            <!-- Columna izquierda con imagen -->
            <div class="col-lg-5 d-none d-lg-flex align-items-center justify-content-center p-4" style="background: #eef5ea;">
                <img src="{{ asset('images/logofertirriego.png') }}" alt="Logo Fertirriego" class="img-fluid" style="max-height: 300px;">
            </div>

            <!-- Columna derecha con formulario -->
            <div class="col-lg-7 p-4 p-md-5">
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
                        <input type="text" name="nombre" class="form-control input-custom" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Imagen</label>
                        <input type="file" name="image_url" class="form-control input-custom">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción *</label>
                        <textarea name="descripcion" class="form-control input-custom" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Precio Bs.*</label>
                            <input type="number" step="0.01" name="precio" class="form-control input-custom" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unidad *</label>
                            <select name="unidad" class="form-select input-custom" required>
                                <option value="">Seleccione una opción</option>
                                <option value="Kg">Kg</option>
                                <option value="Manojo">Manojo</option>
                                <option value="Bolsa">Bolsa</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Stock *</label>
                            <input type="number" name="stock" class="form-control input-custom" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Origen</label>
                        <input type="text" name="origen" class="form-control input-custom">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Beneficios</label>
                        <textarea name="beneficios" class="form-control input-custom"></textarea>
                    </div>

                    <div class="form-check mb-4">
                        <input type="checkbox" name="disponible" class="form-check-input" value="1" checked>
                        <label class="form-check-label">Disponible</label>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success flex-grow-1">Guardar</button>
                        <a href="{{ route('productos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background-color: #f3f4f6;
    }

    .input-custom {
        border-radius: 10px;
        border: 2px solid #e1e8e1;
        background-color: #fbfbfb;
        transition: border-color 0.3s ease;
    }

    .input-custom:focus {
        border-color: #64A500 !important;
        box-shadow: 0 0 0 0.2rem rgba(100, 165, 0, 0.2);
    }

    .form-check-input:checked {
        background-color: #64A500;
        border-color: #64A500;
    }

    .btn-success {
        background-color: #64A500;
        border-color: #64A500;
        border-radius: 8px;
    }

    .btn-success:hover {
        background-color: #558c00;
        border-color: #558c00;
    }

    .btn-outline-secondary {
        border-radius: 8px;
    }

    @media (max-width: 992px) {
        .form-wrapper .col-lg-5 {
            display: none;
        }
    }
</style>
@endsection
