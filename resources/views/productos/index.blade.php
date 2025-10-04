@extends('layout')

@section('title', 'Productos - Fertirriego')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-products.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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

<!-- Botón carrito flotante con contador -->
<!-- Botón carrito flotante con contador solo para compradores -->
@if(auth()->check() && auth()->user()->rol === 'comprador')
    <div id="floatingCartContainer" onclick="mostrarCarrito()">
        <span>🛒 Ver Carrito</span>
        <span id="cartCount">0</span>
    </div>
@endif

<div class="container my-5">
    
    <!-- Buscador y orden -->
    <!-- Buscador y filtro en una sola fila -->
<div class="search-filter-row mb-4">
    <div class="search-box">
        <div class="input-group">
            <input type="text" id="searchInput" class="form-control" placeholder="Buscar producto...">
            <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
    </div>
    <div class="filter-box">
        <select id="sortSelect" class="form-select">
            <option value="name">Nombre</option>
            <option value="price-low">Precio: Menor a Mayor</option>
            <option value="price-high">Precio: Mayor a Menor</option>
            <option value="stock">Stock</option>
        </select>
    </div>
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

                <div class="card-body d-flex flex-column">
                    <h5 class="card-title"> {{ $producto->nombre }}</h5>
                    <p class="card-text flex-grow-1">{{ $producto->descripcion }}</p>
                    <p class="fw-bold text-success">Bs. {{ number_format($producto->precio, 2, ',', '.') }} / {{ $producto->unidad }}</p>

                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-primary btn-sm" onclick="verDetalles({{ $producto->id }})">
                            <i class="fas fa-eye"></i> Detalles
                        </button>
                        <button class="btn btn-impacto btn-sm" onclick="agregarAlCarrito({{ $producto->id }})" {{ !$producto->disponible ? 'disabled' : '' }}>
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
      <div class="modal-footer" id="productModalFooter">
        <!-- Botón agregar al carrito se añade dinámicamente -->
      </div>
    </div>
  </div>
</div>

<!-- MODAL CARRITO -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cartModalLabel">Tu Carrito de Compras</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="cartContent">
        <!-- Aquí se cargan los productos del carrito -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="finalizarCompra()">Finalizar Compra</button>
      </div>
    </div>
  </div>
</div>
</div>
@include('productos.checkout-modal')


@endsection
@push('scripts')
<script src="{{ asset('js/cart.js') }}"></script>
<script src="{{ asset('js/products-updated.js') }}"></script>

<script>
// --- PASAR EL ID Y ROL DEL USUARIO A JS ---
const CURRENT_USER_ID = {{ auth()->check() ? auth()->user()->id : 'null' }};
const CURRENT_USER_ROLE = "{{ auth()->check() ? auth()->user()->rol : '' }}";

document.addEventListener('DOMContentLoaded', () => {
    // Si no es comprador, limpiamos carrito y bloqueamos funciones
    if (CURRENT_USER_ROLE !== 'comprador') {
        localStorage.removeItem('carrito');
        localStorage.removeItem('carrito_user_id');
        // Opcional: ocultar botón carrito si está en la página
        const cartBtn = document.getElementById('floatingCartContainer');
        if (cartBtn) cartBtn.style.display = 'none';
        return; // No continuar con funciones de carrito
    }

    // 1. VALIDAR SI EL CARRITO PERTENECE AL USUARIO ACTUAL
    const storedUserId = localStorage.getItem('carrito_user_id');
    if (storedUserId !== String(CURRENT_USER_ID)) {
        localStorage.removeItem('carrito');
        localStorage.setItem('carrito_user_id', CURRENT_USER_ID);
    }

    // 2. ACTUALIZAR CONTADOR DEL CARRITO
    actualizarContadorCarrito();

    // 3. POSICIONAR EL BOTÓN FLOTANTE DEL CARRITO
    const cartButton = document.getElementById('floatingCartContainer');
    if (!cartButton) return; // En caso no exista

    const initialTop = 180;
    const paddingFromTop = 60;

    function moveCartButton() {
        const scrollY = window.scrollY;
        const newTop = Math.max(initialTop, scrollY + paddingFromTop);
        cartButton.style.top = `${newTop}px`;
    }

    window.addEventListener('scroll', moveCartButton);
    moveCartButton(); // Ejecutar al cargar
});

// Mostrar detalles producto + botón agregar al carrito en modal
function verDetalles(id) {
    fetch(`/api/productos/${id}`)
        .then(res => {
            if (!res.ok) throw new Error('Error al obtener producto');
            return res.json();
        })
        .then(producto => {
            const html = `
  <div class="row">
    <div class="col-md-5 text-center">
      <img src="/${producto.image_url}" class="img-fluid rounded mb-3" alt="${producto.nombre}">
    </div>
    <div class="col-md-7">
      <h4 class="mb-2" style="font-weight: bold; color: #2b9348;"> ${producto.nombre}</h4>
      
      <p class="text-muted">${producto.descripcion}</p>

      <p style="color: #2b9348; font-size: 1.2rem;">
        💰 Bs. ${parseFloat(producto.precio).toFixed(2)} / ${producto.unidad}
      </p>

      <p>🌱 Origen: <span class="text-muted">${producto.origen}</span></p>

      <p class="mt-3"><strong>✨ Stock:</strong> <span class="text-muted">${producto.stock} disponibles</span></p>
      <p class="mt-3"><strong>✨ Beneficios:</strong></p>
      <p class="text-muted">${producto.beneficios}</p>

      ${producto.disponible
        ? '<span class="badge bg-success mt-2">✅ Disponible</span>'
        : '<span class="badge bg-danger mt-2">❌ No disponible</span>'}
    </div>
  </div>
`;

            document.getElementById('productDetails').innerHTML = html;

            // Botón agregar al carrito en modal footer solo si es comprador y disponible
            const footer = document.getElementById('productModalFooter');

            if(CURRENT_USER_ROLE === 'comprador' && producto.disponible) {
                footer.innerHTML = `<button class="btn btn-impacto btn-lg me-2" onclick="agregarAlCarrito(${producto.id})"><i class="fas fa-cart-plus"></i> Agregar al carrito</button>`;
            } else {
                footer.innerHTML = `<button class="btn btn-secondary" disabled>No disponible para agregar</button>`;
            }

            const modal = new bootstrap.Modal(document.getElementById('productModal'));
            modal.show();
        })
        .catch(err => {
            console.error(err);
            document.getElementById('productDetails').innerHTML = '<p class="text-danger">No se pudo cargar el producto.</p>';
            document.getElementById('productModalFooter').innerHTML = '';
        });
}

// Función para agregar producto al carrito
function agregarAlCarrito(id, boton = null) {
    // Solo compradores pueden agregar
    if (CURRENT_USER_ROLE !== 'comprador') {
        mostrarToast("Solo compradores pueden usar el carrito.", true);
        return;
    }

    if (boton) boton.disabled = true;

    fetch(`/api/productos/${id}`)
        .then(res => {
            if (!res.ok) throw new Error('No se pudo obtener el producto');
            return res.json();
        })
        .then(producto => {
            let carrito = JSON.parse(localStorage.getItem('carrito')) || [];

            const index = carrito.findIndex(p => p.id === producto.id);

            if (index !== -1) {
                if (carrito[index].cantidad + 1 > producto.stock) {
                    mostrarToast(`No hay suficiente stock de ${producto.nombre}. Stock disponible: ${producto.stock}`, true);
                    return;
                }
                carrito[index].cantidad += 1;
            } else {
                if (producto.stock < 1) {
                    mostrarToast(`Este producto no tiene stock disponible.`, true);
                    return;
                }
                carrito.push({ ...producto, cantidad: 1, precio: parseFloat(producto.precio) });
            }

            localStorage.setItem('carrito', JSON.stringify(carrito));
            actualizarContadorCarrito();
            mostrarToast(`${producto.nombre} agregado al carrito.`, false);
        })
        .catch(err => {
            console.error(err);
            mostrarToast("No se pudo agregar el producto al carrito.", true);
        })
        .finally(() => {
            if (boton) boton.disabled = false;
        });
}

// Mostrar carrito modal
let cartModalInstance = null;

function mostrarCarrito() {
    if (CURRENT_USER_ROLE !== 'comprador') {
        mostrarToast("Solo compradores pueden ver el carrito.", true);
        return;
    }

    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const cartContent = document.getElementById('cartContent');

    if (carrito.length === 0) {
        cartContent.innerHTML = `<p>Tu carrito está vacío.</p>`;
    } else {
        let html = `
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Precio unitario</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
        `;

        let total = 0;
        carrito.forEach((item, index) => {
            const precio = parseFloat(item.precio) || 0;
            const subtotal = precio * item.cantidad;
            total += subtotal;

            html += `
                <tr>
                    <td>${item.nombre}</td>
                    <td>Bs. ${precio.toFixed(2)}</td>
                    <td>
                        <input type="number" min="1" value="${item.cantidad}" style="width: 60px;" onchange="actualizarCantidad(${index}, this.value)">
                    </td>
                    <td>Bs. ${subtotal.toFixed(2)}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="quitarDelCarrito(${index})"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
        });

        html += `
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th>Bs. ${total.toFixed(2)}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        `;

        cartContent.innerHTML = html;
    }

    if (!cartModalInstance) {
        const modalElement = document.getElementById('cartModal');
        cartModalInstance = new bootstrap.Modal(modalElement, {});

        modalElement.addEventListener('hidden.bs.modal', () => {
            cartModalInstance = null;
        });
    }

    cartModalInstance.show();
}

// Actualizar cantidad en el carrito
function actualizarCantidad(index, nuevaCantidad) {
    if (CURRENT_USER_ROLE !== 'comprador') {
        mostrarToast("Solo compradores pueden modificar el carrito.", true);
        return;
    }

    nuevaCantidad = parseInt(nuevaCantidad);
    if (nuevaCantidad < 1) return;

    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const producto = carrito[index];

    fetch(`/api/productos/${producto.id}`)
        .then(res => res.json())
        .then(data => {
            if (nuevaCantidad > data.stock) {
                mostrarToast(`No hay suficiente stock. Solo quedan ${data.stock} unidades de ${producto.nombre}.`, true);
                mostrarCarrito(); // para refrescar
                return;
            }

            carrito[index].cantidad = nuevaCantidad;
            localStorage.setItem('carrito', JSON.stringify(carrito));
            mostrarCarrito();
        })
        .catch(err => {
            console.error(err);
            mostrarToast("Error al validar stock del producto.", true);
        });
}

function quitarDelCarrito(index) {
    if (CURRENT_USER_ROLE !== 'comprador') {
        mostrarToast("Solo compradores pueden modificar el carrito.", true);
        return;
    }

    let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    carrito.splice(index, 1);
    localStorage.setItem('carrito', JSON.stringify(carrito));

    actualizarContadorCarrito();
    mostrarCarrito();
}

function finalizarCompra() {
    const modal = new bootstrap.Modal(document.getElementById('checkoutModal'));
    modal.show();
}


// Mostrar notificaciones tipo toast
function mostrarToast(mensaje, esError = false) {
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-white ${esError ? 'bg-danger' : 'bg-success'} border-0`;
    toast.style.position = 'fixed';
    toast.style.top = '20px';
    toast.style.right = '20px';
    toast.style.zIndex = 1100;
    toast.style.minWidth = '250px';
    toast.role = 'alert';
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');

    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body" style="font-size: 1.1rem;">${mensaje}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
        </div>
    `;

    document.body.appendChild(toast);

    const bsToast = new bootstrap.Toast(toast, { delay: 3500 });
    bsToast.show();

    toast.addEventListener('hidden.bs.toast', () => {
        toast.remove();
    });
}

// Actualizar contador del carrito en icono flotante
function actualizarContadorCarrito() {
    const carrito = JSON.parse(localStorage.getItem('carrito')) || [];
    const totalItems = carrito.reduce((sum, item) => sum + item.cantidad, 0);
    const cartCount = document.getElementById('cartCount');
    if(cartCount) cartCount.textContent = totalItems;
}
// Vaciar carrito (despues de la compra)
function vaciarCarrito() {
  localStorage.removeItem('carrito');
  localStorage.removeItem('carrito_user_id');
  actualizarContadorCarrito();
}

</script>
@endpush
