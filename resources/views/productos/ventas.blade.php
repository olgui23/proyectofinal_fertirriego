@extends('layout')

@section('title', 'Listado de Ventas')

@section('contenido')
<div class="container my-6">
    <div class="mi-cuadro">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0" style="color: #64A500; font-family: 'Merriweather', serif; font-weight: 700;">
                📑 Listado de Ventas
            </h2>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($ventas->isEmpty())
            <div class="alert alert-info">Aún no se registraron ventas.</div>
        @else
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-bordered align-middle text-center">
                    <thead style="background-color: #64A500; color: white;">
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Productos</th>
                            <th>Comprobante Cliente</th>
                            <th>Comprobante Sistema</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->user->name ?? $venta->telefono_contacto ?? 'Cliente Anónimo' }}</td>
                                <td>{{ $venta->fecha_venta }}</td>
                                <td>Bs. {{ number_format($venta->total, 2) }}</td>
                                <td>
                                    @if($venta->estado === 'pendiente')
                                        <span class="badge bg-warning">Pendiente</span>
                                    @elseif($venta->estado === 'aprobado')
                                        <span class="badge bg-success">Aprobado</span>
                                    @else
                                        <span class="badge bg-danger">Rechazado</span>
                                    @endif
                                </td>
                                <td>
                                    <ul class="text-start">
                                        @foreach ($venta->detalles as $detalle)
                                            <li>
                                                {{ $detalle->producto->nombre ?? 'Producto Eliminado' }} 
                                                (x{{ $detalle->cantidad }}) - 
                                                Bs. {{ number_format($detalle->precio_unitario, 2) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <!-- Comprobante subido por el cliente -->
                                <td>
                                    @if($venta->comprobante_pago)
                                        <a href="{{ asset('storage/'.$venta->comprobante_pago) }}" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-info mb-1">
                                           📄 Ver
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <!-- Comprobante generado por el sistema -->
                                <td>
                                    @if($venta->estado === 'aprobado')
                                        <a href="{{ route('ventas.pdf', $venta->id) }}" target="_blank" class="btn btn-sm btn-info">
                                            📄 Comprobante de venta
                                        </a>
                                    @elseif($venta->estado === 'rechazado')
                                        <a href="{{ route('ventas.pdf', $venta->id) }}" target="_blank" class="btn btn-sm btn-danger">
                                            📄 Nota de rechazo
                                        </a>
                                    @else
                                        <span class="text-muted">Pendiente de aprobación</span>
                                    @endif
                                </td>
                                <!-- Acciones: aprobar/rechazar -->
                                <td>
                                    @if($venta->estado === 'pendiente')
                                        <form action="{{ route('ventas.aprobar', $venta->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-success">Aceptar</button>
                                        </form>
                                        <form action="{{ route('ventas.rechazar', $venta->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Rechazar</button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

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

    ul.text-start {
        padding-left: 0;
        list-style-position: inside;
    }
</style>
@endsection
