@if($venta)
<div class="modal-header text-white" style="background-color: #64A500 !important;">
    <h5 class="modal-title">Detalle de Venta #{{ $venta->id }}</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
</div>

<div class="modal-body">
    <div class="row">
        <!-- Columna de Carrusel de Imágenes -->
        <div class="col-md-4 mb-3">
            @if($venta->detalles->count() > 0)
            <div id="carouselVenta{{ $venta->id }}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($venta->detalles as $index => $detalle)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            @if($detalle->producto?->image_url)
                                <img src="{{ asset('storage/productos/' . basename($detalle->producto->image_url)) }}" 
                                     class="d-block w-100 rounded shadow-sm" 
                                     alt="{{ $detalle->producto->nombre }}">
                            @else
                                <img src="{{ asset('img/no-image.png') }}" 
                                     class="d-block w-100 rounded shadow-sm" 
                                     alt="Sin imagen">
                            @endif
                        </div>
                    @endforeach
                </div>
                @if($venta->detalles->count() > 1)
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselVenta{{ $venta->id }}" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselVenta{{ $venta->id }}" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Siguiente</span>
                </button>
                @endif
            </div>
            @else
                <img src="{{ asset('img/no-image.png') }}" class="img-fluid rounded shadow-sm" alt="Sin imagen">
            @endif
        </div>

        <!-- Columna de Datos -->
        <div class="col-md-8">
            <p><strong>Cliente:</strong> {{ $venta->user?->nombre_completo ?? 'No asignado' }}</p>
            <p><strong>Agricultor:</strong> {{ $venta->agricultor?->nombre_completo ?? 'No asignado' }}</p>
            <p><strong>Fecha de Venta:</strong> {{ $venta->fecha_venta->format('d/m/Y H:i') }}</p>
            <p><strong>Total:</strong> Bs. {{ number_format($venta->total, 2) }}</p>
            <p><strong>Estado de Venta:</strong> 
                <span class="badge {{ $venta->estado_venta == 'aprobado' ? 'bg-success' : 'bg-warning' }}">
                    {{ ucfirst($venta->estado_venta) }}
                </span>
            </p>
        </div>
    </div>

    <hr>

    <h6 class="fw-bold text-muted">Productos</h6>
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-success">
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($venta->detalles as $detalle)
                    <tr>
                        <td>{{ $detalle->producto?->nombre ?? 'Producto no encontrado' }}</td>
                        <td>{{ $detalle->cantidad }}</td>
                        <td>Bs. {{ number_format($detalle->precio_unitario, 2) }}</td>
                        <td>Bs. {{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cerrar</button>
</div>
@else
<div class="modal-body">
    <p>No se pudo cargar la venta.</p>
</div>
@endif
