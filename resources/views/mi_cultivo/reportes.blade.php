@extends('layout')

@section('contenido')
<div class="container my-5">

    {{-- Mensaje de éxito --}}
    @if(session('mensaje'))
        <div class="alert alert-success text-center shadow-sm rounded-3">
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- CONTENEDOR GENERAL --}}
    <div class="card shadow-lg border-0 rounded-4 p-5">
        <div class="card-body">

            {{-- ENCABEZADO --}}
            <h2 class="text-center mb-4" style="color: #64A500; font-family: 'Merriweather', serif; font-weight: 700;">
                Registro de Reportes de Cultivo
            </h2>

            {{-- FORMULARIO --}}
            <form action="{{ route('miCultivo.reportes.guardar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="fecha_registro" class="form-label fw-bold">Fecha de Registro</label>
                        <input type="date" name="fecha_registro" id="fecha_registro" class="form-control"
                            value="{{ old('fecha_registro') }}" required>
                        @error('fecha_registro') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="tipo_lechuga" class="form-label fw-bold">Tipo de Lechuga</label>
                        <select name="tipo_lechuga" id="tipo_lechuga" class="form-select" required>
                            <option value="">--Seleccione--</option>
                            <option value="romana" {{ old('tipo_lechuga')=='romana' ? 'selected' : '' }}>Romana</option>
                            <option value="crespa" {{ old('tipo_lechuga')=='crespa' ? 'selected' : '' }}>Crespa</option>
                        </select>
                        @error('tipo_lechuga') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="superficie" class="form-label fw-bold">Superficie</label>
                        <input type="number" step="0.01" name="superficie" id="superficie" class="form-control"
                            value="{{ old('superficie') }}" required>
                        @error('superficie') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="unidad_medida" class="form-label fw-bold">Unidad de Medida</label>
                        <select name="unidad_medida" id="unidad_medida" class="form-select" required>
                            <option value="">--Seleccione--</option>
                            <option value="m2" {{ old('unidad_medida')=='m2' ? 'selected' : '' }}>m²</option>
                            <option value="hectareas" {{ old('unidad_medida')=='hectareas' ? 'selected' : '' }}>Hectáreas</option>
                            <option value="camas" {{ old('unidad_medida')=='camas' ? 'selected' : '' }}>Camas</option>
                        </select>
                        @error('unidad_medida') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="etapa_crecimiento" class="form-label fw-bold">Etapa de Crecimiento</label>
                        <select name="etapa_crecimiento" id="etapa_crecimiento" class="form-select" required>
                            <option value="">--Seleccione--</option>
                            <option value="germinacion" {{ old('etapa_crecimiento')=='germinacion' ? 'selected' : '' }}>Germinación</option>
                            <option value="crecimiento" {{ old('etapa_crecimiento')=='crecimiento' ? 'selected' : '' }}>Crecimiento</option>
                            <option value="floracion" {{ old('etapa_crecimiento')=='floracion' ? 'selected' : '' }}>Floración</option>
                        </select>
                        @error('etapa_crecimiento') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="estado_cultivo" class="form-label fw-bold">Estado del Cultivo</label>
                        <select name="estado_cultivo" id="estado_cultivo" class="form-select" required>
                            <option value="">--Seleccione--</option>
                            <option value="saludable" {{ old('estado_cultivo')=='saludable' ? 'selected' : '' }}>Saludable</option>
                            <option value="con_plagas" {{ old('estado_cultivo')=='con_plagas' ? 'selected' : '' }}>Con Plagas</option>
                            <option value="enfermo" {{ old('estado_cultivo')=='enfermo' ? 'selected' : '' }}>Enfermo</option>
                        </select>
                        @error('estado_cultivo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="estacion_anio" class="form-label fw-bold">Estación del Año</label>
                        <select name="estacion_anio" id="estacion_anio" class="form-select" required>
                            <option value="">--Seleccione--</option>
                            <option value="verano" {{ old('estacion_anio')=='verano' ? 'selected' : '' }}>Verano</option>
                            <option value="otoño" {{ old('estacion_anio')=='otoño' ? 'selected' : '' }}>Otoño</option>
                            <option value="invierno" {{ old('estacion_anio')=='invierno' ? 'selected' : '' }}>Invierno</option>
                            <option value="primavera" {{ old('estacion_anio')=='primavera' ? 'selected' : '' }}>Primavera</option>
                        </select>
                        @error('estacion_anio') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="foto_cultivo" class="form-label fw-bold">Foto del Cultivo (opcional)</label>
                        <input type="file" name="foto_cultivo" id="foto_cultivo" class="form-control">
                        @error('foto_cultivo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-12">
                        <label for="observaciones" class="form-label fw-bold">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" class="form-control" rows="3"
                            placeholder="Escribe comentarios o hallazgos...">{{ old('observaciones') }}</textarea>
                        @error('observaciones') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn" style="background-color:#64A500; color:white; border:none;">
                        Guardar Reporte
                    </button>
                </div>
            </form>

            {{-- SECCIÓN DE TABLA --}}
            <hr class="my-5">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0" style="color: #64A500; font-family: 'Merriweather', serif; font-weight: 700;">
                    Reportes Registrados
                </h3>
                <a href="{{ route('miCultivo.reportes.pdf') }}" class="btn btn-outline-success">
                    Descargar PDF
                </a>
            </div>

            @if($reportes->isEmpty())
                <p class="text-center text-muted mt-3">No hay reportes registrados aún.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped align-middle text-center">
                        <thead class="table-success">
                            <tr>
                                <th>Fecha</th>
                                <th>Tipo Lechuga</th>
                                <th>Superficie</th>
                                <th>Estado</th>
                                <th>Observaciones</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reportes as $reporte)
                                <tr>
                                    <td>
                                        @if($reporte->fecha_registro instanceof \Carbon\Carbon)
                                            {{ $reporte->fecha_registro->format('d-m-Y') }}
                                        @else
                                            {{ \Carbon\Carbon::parse($reporte->fecha_registro)->format('d-m-Y') }}
                                        @endif
                                    </td>
                                    <td>{{ ucfirst($reporte->tipo_lechuga) }}</td>
                                    <td>{{ $reporte->superficie }} {{ $reporte->unidad_medida }}</td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $reporte->estado_cultivo)) }}</td>
                                    <td>{{ $reporte->observaciones }}</td>
                                    <td>
                                        @if($reporte->foto_cultivo)
                                            <img src="{{ asset('storage/' . $reporte->foto_cultivo) }}"
                                                 alt="Foto Cultivo" width="70" class="rounded shadow-sm">
                                        @else
                                            <span class="text-muted">N/A</span>
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

</div>
@endsection
