@extends('layout')

@section('title', 'Detalle de Venta')

@section('contenido')
<div class="container py-4">
    <div class="card shadow">
        <div class="card-header text-white" style="background-color: #64A500 !important;">
            <h4 class="mb-0">Detalle de Venta #{{ $venta->id }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Cliente:</strong> {{ $venta->user ? $venta->user->nombre_completo : 'No asignado' }}</p>
            <p><strong>Agricultor:</strong> {{ $venta->agricultor ? $venta->agricultor->nombre_completo : 'No asignado' }}</p>
            <p><strong>Fecha de Venta:</strong> {{ $venta->fecha_venta->format('d/m/Y H:i') }}</p>
            <p><strong>Total:</strong> ${{ number_format($venta->total, 2) }}</p>
            <p><strong>Estado de Venta:</strong> {{ $venta->estado_venta }}</p>

            <hr>
            <h5 class="mb-3">Productos</h5>
            <div class="table-responsive">
                <table class="table table-bordered">
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
                            <td>{{ $detalle->producto ? $detalle->producto->nombre : 'Producto no encontrado' }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>${{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer text-end">
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cerrar</a>
        </div>
    </div>
</div>
@endsection
