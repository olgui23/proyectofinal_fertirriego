@extends('layout')

@section('contenido')
<section class="page-section clearfix py-5">
    <div class="container py-5">

        {{-- CARD PRINCIPAL --}}
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">

                {{-- TÍTULO --}}
                <h2 class="mb-4 text-center" 
                    style="color: #64A500; font-family: 'Merriweather', serif; font-weight: 700;">
                    Reporte de Riegos - Sistema Fertirriego
                </h2>

                {{-- FORMULARIO DE FILTRO --}}
                <form method="GET" action="{{ route('cultivo.reporte') }}" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                        <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control" 
                               value="{{ $fechaInicio ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_fin" class="form-label">Fecha Fin:</label>
                        <input type="date" name="fecha_fin" id="fecha_fin" class="form-control" 
                               value="{{ $fechaFin ?? '' }}">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-impacto w-100">Filtrar</button>
                    </div>
                </form>

                {{-- BOTÓN PARA DESCARGAR PDF --}}
                <div class="text-end mb-3">
                    <a href="{{ route('cultivo.reporte.pdf', ['fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]) }}" 
                       target="_blank" class="btn btn-impacto">
                        Generar PDF
                    </a>
                </div>

                {{-- TABLA DE RESULTADOS --}}
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Fecha y Hora</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Lectura ADC</th>
                                <th>Humedad (%)</th>
                                <th>Estado</th>
                                <th>Acción Recomendada</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($riegos as $riego)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $riego->fecha_hora }}</td>
                                    <td>{{ $riego->inicio }}</td>
                                    <td>{{ $riego->fin }}</td>
                                    <td>{{ $riego->lectura_adc }}</td>
                                    <td>{{ $riego->humedad }}</td>
                                    <td>{{ $riego->estado }}</td>
                                    <td>{{ $riego->accion }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-3">
                                        No hay registros disponibles en el rango seleccionado.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- BOTÓN VOLVER --}}
                <div class="text-start mt-4">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">
                        ← Volver
                    </a>
                </div>

            </div> {{-- card-body --}}
        </div> {{-- card --}}
    </div> {{-- container --}}
</section>
@endsection
