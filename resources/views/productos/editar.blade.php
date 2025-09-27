@extends('layout')

@section('title', 'Editar Producto')

@section('contenido')
<div class="container my-6">
    <div class="form-container d-flex flex-column flex-lg-row shadow-sm" style="background: white; border-radius: 15px; overflow: hidden;">
        <!-- Columna izquierda con imagen -->
        <div class="col-lg-5 p-0 d-flex align-items-center justify-content-center bg-white">
            <img src="{{ asset('images/logofertirriego.png') }}" alt="Logo Fertirriego" class="img-fluid p-4" style="max-height: 400px;">
        </div>
        
        <!-- Columna derecha con formulario -->
        <div class="col-lg-7 p-4 p-md-5">
            <h2 class="mb-4" style="color: #64A500; font-family: 'Merriweather', serif; font-weight: 700;">Editar producto</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="nombre" class="form-control" required style="border-radius: 8px; border: 2px solid #e1e8e1;" value="{{ old('nombre', $producto->nombre) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Imagen</label>
                    <input type="file" name="image_url" class="form-control" style="border-radius: 8px; border: 2px solid #e1e8e1;" onchange="previewImage(event)">
                    <div class="mt-2">
                        @if($producto->image_url)
                            <img src="{{ asset($producto->image_url) }}" alt="Imagen actual" class="img-fluid" style="max-width: 200px; border-radius: 8px;">
                        @endif
                        <img id="img-preview" src="#" alt="Vista previa" style="display: none; max-width: 200px; border-radius: 8px;">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción *</label>
                    <textarea name="descripcion" class="form-control" required style="border-radius: 8px; border: 2px solid #e1e8e1;">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio *</label>
                        <input type="number" step="0.01" name="precio" class="form-control" required style="border-radius: 8px; border: 2px solid #e1e8e1;" value="{{ old('precio', $producto->precio) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Unidad *</label>
                        <select name="unidad" class="form-select" required style="border-radius: 8px; border: 2px solid #e1e8e1;">
                            <option value="">Seleccione una opción</option>
                            <option value="Kg" {{ old('unidad', $producto->unidad) == 'Kg' ? 'selected' : '' }}>Kg</option>
                            <option value="Manojo" {{ old('unidad', $producto->unidad) == 'Manojo' ? 'selected' : '' }}>Manojo</option>
                            <option value="Bolsa" {{ old('unidad', $producto->unidad) == 'Bolsa' ? 'selected' : '' }}>Bolsa</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Stock *</label>
                        <input type="number" name="stock" class="form-control" required style="border-radius: 8px; border: 2px solid #e1e8e1;" value="{{ old('stock', $producto->stock) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Origen</label>
                    <input type="text" name="origen" class="form-control" style="border-radius: 8px; border: 2px solid #e1e8e1;" value="{{ old('origen', $producto->origen) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Beneficios</label>
                    <textarea name="beneficios" class="form-control" style="border-radius: 8px; border: 2px solid #e1e8e1;">{{ old('beneficios', $producto->beneficios) }}</textarea>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="disponible" class="form-check-input" value="1" style="border: 2px solid #e1e8e1;" {{ old('disponible', $producto->disponible) ? 'checked' : '' }}>
                    <label class="form-check-label">Disponible</label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-impacto flex-grow-1">Actualizar</button>
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

<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('img-preview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    }
</script>
@endsection
