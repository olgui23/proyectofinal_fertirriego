@extends('layout')

@section('title', 'Reportes')

@section('contenido')
<section class="page-section clearfix">
    <div class="container">
        <h2 class="text-center text-success">Reportes Generados</h2>
        
        <!-- Contenedor para el gráfico de barras -->
        <div class="my-5">
            <h3 class="text-center mb-4">Reportes por Mes (Ejemplo)</h3>
            <div class="chart-container" style="position: relative; height:400px; width:100%">
                <canvas id="reportesChart"></canvas>
            </div>
        </div>
        
        <table class="table table-bordered bg-white">
            <thead><tr><th>Título</th><th>Descripción</th><th>Fecha</th></tr></thead>
            <tbody>
                @foreach($reportes as $r)
                <tr>
                    <td>{{ $r->titulo }}</td>
                    <td>{{ $r->descripcion }}</td>
                    <td>{{ $r->fecha }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<!-- Incluir Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Datos de ejemplo para el gráfico (luego los reemplazarás con datos reales)
    const ctx = document.getElementById('reportesChart').getContext('2d');
    const reportesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio'],
            datasets: [{
                label: 'Número de Reportes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    'rgba(75, 192, 192, 0.6)',
                    'rgba(153, 102, 255, 0.6)',
                    'rgba(255, 159, 64, 0.6)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Cantidad de Reportes'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Meses'
                    }
                }
            }
        }
    });
});
</script>
@endsection