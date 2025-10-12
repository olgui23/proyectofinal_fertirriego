@extends('layout')

@section('title', 'Mis Productos')

@section('contenido')
<div class="container my-6">
    <div class="mi-cuadro">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0" style="color: #64A500; font-family: 'Merriweather', serif; font-weight: 700;">Mis productos</h2>
        <a href="{{ route('productos.crear') }}" class="btn btn-impacto" style="border-radius: 8px; padding: 10px 20px;">
            + Agregar nuevo producto
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($productos->isEmpty())
        <div class="alert alert-info">No has agregado ningún producto aún.</div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered align-middle text-center">
                <thead style="background-color: #64A500; color: white;">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Disponible</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                        <tr>
                            <td>
                                @if($producto->image_url)
                                    <img src="{{ asset($producto->image_url ?? 'storage/productos/default.jpg') }}" alt="Imagen" width="60" height="60" style="object-fit: cover; border-radius: 8px;">
                              
                                    @else
                                    <span class="text-muted">Sin imagen</span>
                                @endif
                            </td>
                            <td>{{ $producto->nombre }}</td>
                            <td>Bs. {{ number_format($producto->precio, 2) }}</td>
                            <td>{{ $producto->stock }} {{ $producto->unidad }}</td>
                            <td>
                                @if($producto->disponible)
                                    <span class="badge bg-success">Sí</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('productos.editar', $producto->id) }}" class="btn btn-sm btn-outline-primary">Editar</a>

                                <!-- Botón que abre el modal -->
                                <button 
                                    type="button" 
                                    class="btn btn-sm btn-outline-danger" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#confirmDeleteModal" 
                                    data-product-id="{{ $producto->id }}" 
                                    data-product-name="{{ $producto->nombre }}"
                                >
                                    Eliminar
                                </button>

                                <form action="{{ route('productos.toggleDisponible', $producto->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-warning">
                                        {{ $producto->disponible ? 'No disponible' : 'Disponible' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- MODAL CONFIRMACIÓN -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form id="deleteForm" method="POST" action="">
        @csrf
        @method('DELETE')

        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteLabel">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body">
          <p>¿Estás seguro que deseas eliminar el producto <strong id="productName"></strong>?</p>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
          <button type="submit" class="btn btn-danger">Sí, eliminar</button>
        </div>
      </form>
    </div>
  </div>
</div> </div>

<!-- JavaScript para manejar el modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var deleteModal = document.getElementById('confirmDeleteModal');
        deleteModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var productId = button.getAttribute('data-product-id');
            var productName = button.getAttribute('data-product-name');

            var modalProductName = deleteModal.querySelector('#productName');
            modalProductName.textContent = productName;

            var form = deleteModal.querySelector('#deleteForm');
            form.action = '/productos/' + productId;
        });
    });
</script>

<style>
    .btn-impacto {
        background-color: #64A500;
        color: white;
        font-weight: bold;
        border: none;
    }

    .btn-impacto:hover {
        background-color: #558c00;
        color: white;
    }

    table th, table td {
        vertical-align: middle;
    }
</style>
@endsection
