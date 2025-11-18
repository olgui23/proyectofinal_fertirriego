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
    {{-- FORMULARIO DE FILTRO DE REPORTES --}}
    <form action="{{ route('ventas.index') }}" method="GET" class="row g-3 mb-4">
        <div class="col-md-3">
            <label for="fecha_inicio" class="form-label fw-bold text-success">Desde</label>
            <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
        </div>
        <div class="col-md-3">
            <label for="fecha_fin" class="form-label fw-bold text-success">Hasta</label>
            <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
        </div>
        <div class="col-md-3">
            <label for="estado" class="form-label fw-bold text-success">Estado</label>
            <select name="estado" id="estado" class="form-select">
                <option value="">Todos</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="aprobado" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
                <option value="finalizado" {{ request('estado') == 'finalizado' ? 'selected' : '' }}>Finalizado</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-success w-100">🔍 Filtrar</button>
            <a href="{{ route('ventas.index') }}" class="btn btn-outline-secondary w-100">♻️ Limpiar</a>
        </div>
    </form>

    {{-- BOTÓN PARA GENERAR REPORTE PDF --}}
    <div class="text-end mb-3">
        <a href="{{ route('ventas.reporte', request()->query()) }}" target="_blank" class="btn btn-impacto">
             Generar Reporte PDF
        </a>
    </div>

    {{-- MENSAJES --}}
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
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $venta->user->nombre }}</td>
                            <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y H:i') }}</td>
                            <td>Bs. {{ number_format($venta->total, 2) }}</td>
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
                            <td>
                                @if($venta->comprobante_pago)
                                    <a href="{{ asset('storage/'.$venta->comprobante_pago) }}" target="_blank" class="btn btn-sm btn-outline-info mb-1">
                                        📄 Ver
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($venta->estado_venta === 'pendiente')
                                    <div class="d-flex justify-content-center gap-2">

    <div class="flex-fill">
        <form action="{{ route('ventas.aprobar', $venta->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-success w-100">Aceptar</button>
        </form>
    </div>

    <div class="flex-fill">
        <button type="button"
                class="btn btn-sm btn-danger w-100"
                data-bs-toggle="modal"
                data-bs-target="#rechazoModal{{ $venta->id }}">
            Rechazar
        </button>
    </div>

</div>


                                    {{-- MODAL DE RECHAZO --}}
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
