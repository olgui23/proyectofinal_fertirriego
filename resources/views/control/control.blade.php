@extends('layout')

@section('title', 'Panel de Sensores')

@section('contenido')
<section class="page-section clearfix py-5">
    <div class="container">
        <h2 class="text-center text-success mb-4">Panel de Control de Sensores</h2>

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">

                {{-- Selección de equipo --}}
                <div class="mb-3 text-center">
                    <label for="equipoSelect" class="form-label">Seleccionar Equipo:</label>
                    <select id="equipoSelect" class="form-select w-auto mx-auto">
                        @forelse($equipos as $equipo)
                            <option value="{{ $equipo->id }}">
                                {{ $equipo->descripcion ?? $equipo->mac }}
                            </option>
                        @empty
                            <option value="0">No hay equipos disponibles</option>
                        @endforelse
                    </select>
                </div>

                {{-- Botones de control --}}
                <div class="text-center mb-4">
                    @if($equipos->isNotEmpty())
                    <form id="accionesForm" method="POST">
                        @csrf
                        <button type="button" class="btn btn-success me-2 mb-2" onclick="accion('iniciar_riego')">💧 Iniciar Riego</button>
                        <button type="button" class="btn btn-danger me-2 mb-2" onclick="accion('parar_riego')">🛑 Parar Riego</button>
                        <button type="button" class="btn btn-success me-2 mb-2" onclick="accion('iniciar_fertilizante')">🚿 Iniciar Fertilizante</button>
                        <button type="button" class="btn btn-danger me-2 mb-2" onclick="accion('parar_fertilizante')">🛑 Parar Fertilizante</button>
                        <button type="button" class="btn btn-primary me-2 mb-2" onclick="accion('pulso_fertilizante')">💊 Fertilizante (10s)</button>
                    </form>
                    @else
                        <p class="text-danger">No hay equipos disponibles para controlar.</p>
                    @endif
                </div>

                {{-- Estado actual --}}
                <div class="text-center mb-4">
                    <p>Humedad actual: <strong><span id="humedad">...</span></strong></p>
                    <p>Riego Automático: <span id="estadoRiego">⚪ Apagado</span></p>
                    <p>Fertilizante: <span id="estadoFertilizante">⚪ Apagado</span></p>
                </div>

                {{-- Gráfico de humedad --}}
                <canvas id="grafico" width="400" height="150"></canvas>

            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
@if($equipos->isNotEmpty())
const graficoCtx = document.getElementById('grafico').getContext('2d');
const grafico = new Chart(graficoCtx, {
    type: 'line',
    data: {
        labels: Array(20).fill(''),
        datasets: [{
            label: 'Humedad',
            borderColor: '#2196f3',
            backgroundColor: '#bbdefb',
            data: Array(20).fill(0),
            tension: 0.3,
        }]
    },
    options: {
        responsive: true,
        animation: false,
        scales: {
            y: { beginAtZero: true, max: 4095 }
        }
    }
});

let equipoActual = document.getElementById('equipoSelect').value;

document.getElementById('equipoSelect').addEventListener('change', function() {
    equipoActual = this.value;
    actualizar();
});

function actualizar() {
    fetch(`/reporte-equipos/${equipoActual}/datos`)
        .then(res => res.json())
        .then(data => {
            // Actualiza gráfico
            if(data.historico){
                grafico.data.datasets[0].data = data.historico;
                grafico.update();
            }

            // Último reporte
            const ultimo = data.ultimo_reporte;
            if(ultimo){
                // Humedad: si valor es numérico, si no toma último histórico
                const humedad = ultimo.valor !== null ? ultimo.valor : (data.historico ? data.historico[data.historico.length-1] : '---');
                document.getElementById('humedad').textContent = humedad;

                // Estados según tipo de acción y estado
                const est = ultimo.estado; // 1=activo, 0=finalizado, 2=error
                const accion = ultimo.tipo_accion ?? '';

                document.getElementById('estadoRiego').textContent = (accion.includes('riego') && est==1) ? '🟢 Activado' : '⚪ Apagado';
                document.getElementById('estadoFertilizante').textContent = (accion.includes('fertilizante') && est==1) ? '🟢 Activado' : '⚪ Apagado';
            }
        })
        .catch(err => console.error('Error al cargar datos:', err));
}

setInterval(actualizar, 2000);
actualizar();

function accion(tipo_accion){
    fetch(`/reporte-equipos/accion/${equipoActual}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ tipo_accion })
    }).then(res => {
        if(res.ok){
            console.log(`Acción ${tipo_accion} enviada al equipo ${equipoActual}`);
            actualizar();
        } else console.error('Error enviando la acción.');
    }).catch(err => console.error('Error fetch:', err));
}
@endif
</script>
@endsection
