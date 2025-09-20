@extends('layout')

@section('title', 'Agregar Producto')

@section('contenido')
<div class="container py-5">
    <div class="product-form-card">
        <div class="product-form-header">
            <h2>Agregar nuevo producto</h2>
        </div>

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

            <div class="product-form-row">
                <div class="product-form-col">
                    <label class="form-label">Nombre *</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="product-form-col">
                    <label class="form-label">Unidad *</label>
                    <input type="text" name="unidad" class="form-control" required>
                </div>
                <div class="product-form-col">
                    <label class="form-label">Precio *</label>
                    <input type="number" step="0.01" name="precio" class="form-control" required>
                </div>
            </div>

            <div class="product-form-row">
                <div class="product-form-col">
                    <label class="form-label">Stock *</label>
                    <input type="number" name="stock" class="form-control" required>
                </div>
                <div class="product-form-col">
                    <label class="form-label">Origen</label>
                    <input type="text" name="origen" class="form-control">
                </div>
                <div class="product-form-col">
                    <label class="form-label">Imagen</label>
                    <input type="file" name="image_url" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <div id="img-preview-holder">
                        <img id="img-preview" src="#" alt="Vista previa" class="product-img-preview" style="display: none;">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción *</label>
                <textarea name="descripcion" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Beneficios</label>
                <textarea name="beneficios" class="form-control"></textarea>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" name="disponible" class="form-check-input" value="1" checked>
                <label class="form-check-label">Disponible</label>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>

<!-- Script pequeño para vista previa de imagen -->
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('img-preview');
        const holder = document.getElementById('img-preview-holder');
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
