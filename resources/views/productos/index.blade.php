@extends('layout')

@section('title', 'Productos - Fertirriego')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-products.css') }}">
@endpush

@section('cabecera')
<section class="page-hero products-hero bg-light py-5" style="margin-top: 80px;">
    <div class="container text-center">
        <h1 class="display-4 fw-bold">Nuestros Productos</h1>
        <p class="lead">Elige entre las hortalizas más frescas y saludables, directo del campo a tu mesa</p>
    </div>
</section>
@endsection

@section('contenido')
<div class="container my-5">

    <!-- Buscador y orden -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <div class="input-group w-100 w-md-50 mb-3 mb-md-0">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar producto...">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <select id="sortSelect" class="form-select w-auto ms-md-3">
            <option value="name">Nombre</option>
            <option value="price-low">Precio: Menor a Mayor</option>
            <option value="price-high">Precio: Mayor a Menor</option>
            <option value="stock">Stock</option>
        </select>
    </div>

   <!-- Productos -->
<div id="productsGrid" class="row g-4">
    @forelse($productos as $producto)
        <div class="col-md-4 product-card" data-category="{{ Str::slug($producto->categoria) }}">
            <div class="card h-100 shadow-sm position-relative">
                <img src="{{ asset($producto->image_url ?? 'storage/productos/default.jpg') }}" class="card-img-top" alt="{{ $producto->nombre }}">

                {{-- Badge de disponibilidad --}}
                @if($producto->disponible)
                    <span class="position-absolute top-0 end-0 m-2 badge bg-success">Disponible</span>
                @else
                    <span class="position-absolute top-0 end-0 m-2 badge bg-danger">No disponible</span>
                @endif

                <div class="card-body">
                    <h5 class="card-title"> {{ $producto->nombre }}</h5>
                    <p class="card-text">{{ $producto->descripcion }}</p>
                    <p class="fw-bold text-success">Bs. {{ number_format($producto->precio, 2, ',', '.') }} / {{ $producto->unidad }}</p>

                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-primary btn-sm" onclick="verDetalles({{ $producto->id }})">
                            <i class="fas fa-eye"></i> Detalles
                        </button>
                        <button class="btn btn-success btn-sm" onclick="agregarAlCarrito({{ $producto->id }})" {{ !$producto->disponible ? 'disabled' : '' }}>
                            <i class="fas fa-cart-plus"></i> Agregar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <p class="text-muted">No hay productos disponibles.</p>
        </div>
    @endforelse
</div>

<div id="noResults" class="text-center mt-4 d-none">
    <i class="fas fa-search fa-2x text-muted"></i>
    <p class="text-muted">No se encontraron productos que coincidan.</p>
</div>


<!-- MODAL DETALLES -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productModalLabel">Detalles del Producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="productDetails">
        <div class="text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script>
    <script src="{{ asset('js/products-updated.js') }}"></script>

    <script>
    function verDetalles(id) {
        fetch(`/productos/${id}`)
            .then(res => res.json())
            .then(producto => {
                const html = `
                    <div class="row">
                        <div class="col-md-5">
                            <img src="${producto.image_url}" class="img-fluid rounded" alt="${producto.nombre}">
                        </div>
                        <div class="col-md-7">
                            <h4>${producto.emoji ?? ''} ${producto.nombre}</h4>
                            <p>${producto.descripcion}</p>
                            <p><strong>Precio:</strong> Bs. ${parseFloat(producto.precio).toFixed(2)} / ${producto.unidad}</p>
                            ${producto.disponible
                                ? '<span class="badge bg-success">Disponible</span>'
                                : '<span class="badge bg-danger">No disponible</span>'}
                        </div>
                    </div>
                `;
                document.getElementById('productDetails').innerHTML = html;
                new bootstrap.Modal(document.getElementById('productModal')).show();
            })
            .catch(err => {
                console.error(err);
                document.getElementById('productDetails').innerHTML = '<p class="text-danger">No se pudo cargar el producto.</p>';
            });
    }

    function agregarAlCarrito(id) {
        // Aquí deberías llamar a una función que maneje el carrito (en localStorage o con API)
        alert("Producto agregado al carrito: " + id);
    }

    function abrirCheckout() {
        alert("Implementar checkout");
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const sortSelect = document.getElementById('sortSelect');
        const productsGrid = document.getElementById('productsGrid');
        const noResults = document.getElementById('noResults');

        function filterAndSortProducts() {
            const searchTerm = searchInput.value.toLowerCase();
            const sortOption = sortSelect.value;
            let products = [...productsGrid.children];

            products.forEach(card => {
                const name = card.querySelector('.card-title').textContent.toLowerCase();
                const matchesSearch = name.includes(searchTerm);
                card.style.display = matchesSearch ? '' : 'none';
            });

            let visibleProducts = products.filter(p => p.style.display !== 'none');

            visibleProducts.sort((a, b) => {
                const getPrice = el => parseFloat(el.querySelector('.fw-bold').textContent.replace(/[^0-9.,]/g,"").replace(",", "."));
                switch (sortOption) {
                    case 'name':
                        return a.querySelector('.card-title').textContent.localeCompare(b.querySelector('.card-title').textContent);
                    case 'price-low':
                        return getPrice(a) - getPrice(b);
                    case 'price-high':
                        return getPrice(b) - getPrice(a);
                    case 'stock':
                        return 0; // Reemplaza si tienes stock
                    default:
                        return 0;
                }
            });

            visibleProducts.forEach(p => productsGrid.appendChild(p));
            noResults.classList.toggle('d-none', visibleProducts.length > 0);
        }

        searchInput.addEventListener('input', filterAndSortProducts);
        sortSelect.addEventListener('change', filterAndSortProducts);
    });
    </script>
@endpush
