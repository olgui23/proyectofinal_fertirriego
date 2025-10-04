@extends('layout')

@section('title', 'Listado de Ventas')

@section('contenido')
<div class="container my-6">
    <div class="mi-cuadro">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0" style="color: #64A500; font-family: 'Merriweather', serif; font-weight: 700;">
                Listado de Ventas
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
                            <th>Acciones</th>
                            <th>Comprobante Sistema</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $index => $venta)
                            <tr>
                                <!-- Numeración -->
                                <td>{{ $index + 1 }}</td>

                                <!-- Cliente -->
                                <td>{{ $venta->user->name }}</td>

                                <!-- Fecha -->
                                <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}</td>

                                <!-- Total -->
                                <td>Bs. {{ number_format($venta->total, 2) }}</td>

                                <!-- Estado -->
                                <td>
    @if($venta->estado_venta === 'pendiente')
    <span class="badge bg-warning">Pendiente</span>
@elseif($venta->estado_venta === 'aprobado')
    <span class="badge bg-success">Aprobado</span>
@elseif($venta->estado_venta === 'cancelado' || $venta->estado_venta === 'rechazado')
    <span class="badge bg-danger">Rechazado</span>
@elseif($venta->estado_venta === 'finalizado')
    <span class="badge bg-primary">Finalizado</span>
@endif

</td>


                                <!-- Productos -->
                                <td class="text-start">
                                    <ul class="mb-0">
                                        @foreach ($venta->detalles as $detalle)
                                            <li>
                                                {{ $detalle->producto->nombre ?? 'Producto Eliminado' }} 
                                                (x{{ $detalle->cantidad }}) - Bs. {{ number_format($detalle->precio_unitario, 2) }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>

                                <!-- Comprobante Cliente -->
                                <td>
                                    @if($venta->comprobante_pago)
                                        <a href="{{ asset('storage/'.$venta->comprobante_pago) }}" target="_blank" class="btn btn-sm btn-outline-info mb-1">
                                            📄 Ver
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>

                                <!-- Acciones -->
                                <td>
                                    @if($venta->estado_venta === 'pendiente')
                                        <div class="d-flex justify-content-center gap-2">
                                            <form action="{{ route('ventas.aprobar', $venta->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success w-100">Aceptar</button>
                                            </form>

                                            <!-- Botón Modal Rechazo -->
                                            <button type="button" class="btn btn-sm btn-danger w-100" data-bs-toggle="modal" data-bs-target="#rechazoModal{{ $venta->id }}">
                                                Rechazar
                                            </button>
                                        </div>

                                        <!-- Modal Rechazo -->
                                        <div class="modal fade" id="rechazoModal{{ $venta->id }}" tabindex="-1" aria-labelledby="rechazoModalLabel{{ $venta->id }}" aria-hidden="true">
                                          <div class="modal-dialog">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="rechazoModalLabel{{ $venta->id }}">Confirmar Rechazo</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                              </div>
                                              <div class="modal-body">
                                                ¿Estás seguro de que deseas rechazar/cancelar esta venta?
                                              </div>
                                              <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('ventas.rechazar', $venta->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Sí, rechazar</button>
                                                </form>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <!-- Comprobante Sistema -->
                                <td>
    @if($venta->estado_venta === 'aprobado')
        <a href="{{ route('ventas.pdf', $venta->id) }}" target="_blank" class="btn btn-sm btn-info">
            📄 Comprobante de venta
        </a>
    @elseif($venta->estado_venta === 'cancelado')
        <a href="{{ route('ventas.pdf', $venta->id) }}" target="_blank" class="btn btn-sm btn-danger">
            📄 Nota de rechazo
        </a>
    @else
        <span class="text-muted"> - </span>
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
