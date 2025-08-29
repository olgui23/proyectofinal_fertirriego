@extends('layout')

@section('title', 'Asistente')

@section('contenido')
<div class="container mt-5">
    <h2 class="fw-bold text-success mb-4">🤖 Asistente Virtual</h2>

    <form action="{{ route('asistente.responder') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="pregunta" class="form-label">Escribe tu pregunta:</label>
            <textarea name="pregunta" id="pregunta" class="form-control" rows="3" required>{{ old('pregunta') }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Enviar</button>
    </form>

    @if(isset($respuesta))
        <div class="alert alert-info mt-4">
            <strong>Respuesta:</strong> {{ $respuesta }}
        </div>
    @endif
</div>
@endsection
