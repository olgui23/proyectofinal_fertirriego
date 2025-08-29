@extends('layout')

@section('contenido')
<div class="container mt-5">

    @if(session('mensaje'))
        <div class="alert alert-success">{{ session('mensaje') }}</div>
    @endif

    <h2>Registrar nuevo reporte</h2>
    <form action="{{ route('miCultivo.reportes.guardar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="fecha_registro" class="form-label">Fecha de Registro</label>
            <input type="date" name="fecha_registro" id="fecha_registro" class="form-control" value="{{ old('fecha_registro') }}" required>
            @error('fecha_registro') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="tipo_lechuga" class="form-label">Tipo de Lechuga</label>
            <select name="tipo_lechuga" id="tipo_lechuga" class="form-select" required>
                <option value="">--Seleccione--</option>
                <option value="romana" {{ old('tipo_lechuga')=='romana' ? 'selected' : '' }}>Romana</option>
                <option value="crespa" {{ old('tipo_lechuga')=='crespa' ? 'selected' : '' }}>Crespa</option>
                <!-- Agrega más tipos según necesites -->
            </select>
            @error('tipo_lechuga') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="superficie" class="form-label">Superficie</label>
            <input type="number" step="0.01" name="superficie" id="superficie" class="form-control" value="{{ old('superficie') }}" required>
            @error('superficie') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="unidad_medida" class="form-label">Unidad de Medida</label>
            <select name="unidad_medida" id="unidad_medida" class="form-select" required>
                <option value="">--Seleccione--</option>
                <option value="m2" {{ old('unidad_medida')=='m2' ? 'selected' : '' }}>m²</option>
                <option value="hectareas" {{ old('unidad_medida')=='hectareas' ? 'selected' : '' }}>Hectáreas</option>
                <option value="camas" {{ old('unidad_medida')=='camas' ? 'selected' : '' }}>Camas</option>
            </select>
            @error('unidad_medida') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="etapa_crecimiento" class="form-label">Etapa de Crecimiento</label>
            <select name="etapa_crecimiento" id="etapa_crecimiento" class="form-select" required>
                <option value="">--Seleccione--</option>
                <option value="germinacion" {{ old('etapa_crecimiento')=='germinacion' ? 'selected' : '' }}>Germinación</option>
                <option value="crecimiento" {{ old('etapa_crecimiento')=='crecimiento' ? 'selected' : '' }}>Crecimiento</option>
                <option value="floracion" {{ old('etapa_crecimiento')=='floracion' ? 'selected' : '' }}>Floración</option>
                <!-- Añade otras etapas si tienes -->
            </select>
            @error('etapa_crecimiento') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="estado_cultivo" class="form-label">Estado del Cultivo</label>
            <select name="estado_cultivo" id="estado_cultivo" class="form-select" required>
                <option value="">--Seleccione--</option>
                <option value="saludable" {{ old('estado_cultivo')=='saludable' ? 'selected' : '' }}>Saludable</option>
                <option value="con_plagas" {{ old('estado_cultivo')=='con_plagas' ? 'selected' : '' }}>Con Plagas</option>
                <option value="enfermo" {{ old('estado_cultivo')=='enfermo' ? 'selected' : '' }}>Enfermo</option>
            </select>
            @error('estado_cultivo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="estacion_anio" class="form-label">Estación del Año</label>
            <select name="estacion_anio" id="estacion_anio" class="form-select" required>
                <option value="">--Seleccione--</option>
                <option value="verano" {{ old('estacion_anio')=='verano' ? 'selected' : '' }}>Verano</option>
                <option value="otoño" {{ old('estacion_anio')=='otoño' ? 'selected' : '' }}>Otoño</option>
                <option value="invierno" {{ old('estacion_anio')=='invierno' ? 'selected' : '' }}>Invierno</option>
                <option value="primavera" {{ old('estacion_anio')=='primavera' ? 'selected' : '' }}>Primavera</option>
            </select>
            @error('estacion_anio') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea name="observaciones" id="observaciones" class="form-control" rows="3">{{ old('observaciones') }}</textarea>
            @error('observaciones') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="foto_cultivo" class="form-label">Foto del Cultivo (opcional)</label>
            <input type="file" name="foto_cultivo" id="foto_cultivo" class="form-control">
            @error('foto_cultivo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar Reporte</button>
    </form>

    <hr>

    <h2 class="mt-4">Reportes Registrados</h2>

    <a href="{{ route('miCultivo.reportes.pdf') }}" class="btn btn-success mb-3">Descargar Reporte PDF</a>

    @if($reportes->isEmpty())
        <p>No hay reportes registrados aún.</p>
    @else
        <table class="table table-striped">
            <thead>
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
                        <td>{{ $reporte->fecha_registro->format('d-m-Y') }}</td>
                        <td>{{ ucfirst($reporte->tipo_lechuga) }}</td>
                        <td>{{ $reporte->superficie }} {{ $reporte->unidad_medida }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $reporte->estado_cultivo)) }}</td>
                        <td>{{ $reporte->observaciones }}</td>
                        <td>
                            @if($reporte->foto_cultivo)
                                <img src="{{ asset('storage/' . $reporte->foto_cultivo) }}" alt="Foto Cultivo" width="80">
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
