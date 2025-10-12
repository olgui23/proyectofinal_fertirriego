@extends('layout')

@section('title', 'Mis Compras - Fertirriego')

@section('contenido')
<div class="container py-5">
    <!-- Contenedor principal con sombra y estilo -->
    <div class="main-content-container p-4 shadow-sm rounded-4">
        <!-- Encabezado -->
        <div class="text-center mb-5">
            <h1 class="plagas-title">🛍️ Mis Compras</h1>
            <p class="calendar-subtitle">Aquí puedes ver el estado y detalles de tus compras realizadas.</p>
        </div>

        @if($ventas->isEmpty())
            <div class="alert alert-info text-center shadow-sm rounded-3">
                <i class="bi bi-info-circle"></i> Aún no tienes compras registradas.
            </div>
        @else
            <div class="row g-4">
                @foreach($ventas as $venta)
                    <div class="col-md-6 col-lg-4">
                        <div class="card pest-card hover-card h-100">
                            <div class="card-body d-flex flex-column">
                                <h5 class="pest-title mb-2">Compra #{{ $venta->id }}</h5>
                                <p class="mb-1"><strong>Fecha:</strong> {{ $venta->fecha_venta->format('d/m/Y H:i') }}</p>
                                <p class="mb-1"><strong>Total:</strong> Bs {{ number_format($venta->total, 2) }}</p>
                                <p class="mb-2"><strong>Estado:</strong>
                                    @if($venta->estado_venta === 'pendiente')
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    @elseif($venta->estado_venta === 'aprobado')
                                        <span class="badge" style="background-color: #6CBF6B; color:white;">Aprobado</span>
                                    @else
                                        <span class="badge bg-danger">Rechazado</span>
                                    @endif
                                </p>

                                <div class="mt-auto d-flex justify-content-between">
                                    @if($venta->estado_venta === 'aprobado')
                                        <a href="{{ route('ventas.pdf', $venta->id) }}" target="_blank" class="btn btn-green">
                                            <i class="bi bi-file-earmark-pdf"></i> Comprobante
                                        </a>
                                    @else
                                        <button class="btn btn-secondary" disabled>
                                            <i class="bi bi-file-earmark-pdf"></i> Comprobante
                                        </button>
                                    @endif

                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-detalle" data-id="{{ $venta->id }}">
                                        <i class="bi bi-eye"></i> Detalles
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Modal Detalle de Compra dentro del contenedor -->
        <div id="detalleVentaWrapper">
            <div class="modal fade" id="detalleCompraModal" tabindex="-1" aria-labelledby="detalleCompraModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content shadow-lg rounded-4">
                        <div id="detalleCompraContent" class="p-3">
                            <!-- Contenido AJAX inyectado aquí -->
                            <div class="text-center py-5">
                                <div class="spinner-border text-success" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- fin main-content-container -->
</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const detalleButtons = document.querySelectorAll('.btn-detalle');
    detalleButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const ventaId = this.dataset.id;

            const modal = new bootstrap.Modal(document.getElementById('detalleCompraModal'));
            modal.show();

            document.getElementById('detalleCompraContent').innerHTML = `
                <div class="text-center py-5">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                </div>
            `;

            fetch(`/ventas/${ventaId}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('detalleCompraContent').innerHTML = html;
            })
            .catch(err => {
                document.getElementById('detalleCompraContent').innerHTML = `
                    <div class="alert alert-danger text-center">Error al cargar los detalles.</div>
                `;
                console.error(err);
            });
        });
    });
});
</script>
@endpush
