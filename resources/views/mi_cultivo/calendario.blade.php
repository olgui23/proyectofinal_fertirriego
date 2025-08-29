@extends('layout')

@section('title', 'Calendario del Agricultor')

@section('contenido')
<div class="container mt-5">
    <h2 class="text-success fw-bold">📅 Calendario del Agricultor</h2>
    <p class="lead">Cuidados mensuales y alertas climáticas para el cultivo de lechuga en Tiquipaya</p>

    <div class="card">
    <div class="card-header bg-success text-white">
        <h5>🌦️ Clima en Tiquipaya</h5>
    </div>
    <div class="card-body">
        <div id="clima-container">
            <p>Cargando datos...</p>
        </div>
    </div>
</div>

@section('scripts')
<script>
    fetch('/api/clima-tiquipaya')
        .then(response => response.json())
        .then(data => {
            if (data.cod === 200) {
                const clima = `
                    <p>Temperatura: ${data.main.temp}°C</p>
                    <p>Humedad: ${data.main.humidity}%</p>
                    <p>Condición: ${data.weather[0].description}</p>
                `;
                document.getElementById('clima-container').innerHTML = clima;
            } else {
                document.getElementById('clima-container').innerHTML = `
                    <p class="text-danger">Error: ${data.message}</p>
                `;
            }
        });
</script>
@endsection
    
    
    
    
    
    
    
    
    <!-- Sección del Clima en Tiempo Real -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">🌦️ Clima Actual en Tiquipaya</h4>
            <small id="last-update" class="fw-light">Actualizando...</small>
        </div>
        <div class="card-body">
            <div class="row" id="weather-container">
                <div class="col-12 text-center">
                    <div class="spinner-border text-success" role="status">
                        <span class="visually-hidden">Cargando...</span>
                    </div>
                    <p class="mt-2">Cargando datos meteorológicos...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas Climáticas -->
    <div class="card mb-4 shadow-sm border-warning">
        <div class="card-header bg-warning text-dark">
            <h4 class="mb-0">⚠️ Alertas Agrícolas</h4>
        </div>
        <div class="card-body" id="weather-alerts">
            <div class="alert alert-info">
                Cargando alertas para tu cultivo...
            </div>
        </div>
    </div>

    <!-- Calendario Mensual -->
    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0">🗓️ Recomendaciones Mensuales para Lechuga</h4>
        </div>
        <div class="card-body">
            <div class="row">
                @php
                    $currentMonth = now()->month;
                    $months = [
                        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                    ];
                @endphp

                @foreach($months as $num => $name)
                <div class="col-md-6 mb-4">
                    <div class="card h-100 {{ $num == $currentMonth ? 'border-success' : '' }}">
                        <div class="card-header {{ $num == $currentMonth ? 'bg-success text-white' : 'bg-light' }}">
                            <h5>{{ $name }}</h5>
                        </div>
                        <div class="card-body">
                            @if($num == $currentMonth)
                                <span class="badge bg-success">Mes Actual</span>
                            @endif
                            <p class="mt-2">
                                @switch($num)
                                    @case(1)
                                        • Riego: Moderado (cada 2-3 días)<br>
                                        • Controlar humedad del suelo<br>
                                        • Preparar semilleros protegidos
                                        @break
                                    @case(2)
                                        • Cosecha principal<br>
                                        • Vigilar pulgones por humedad<br>
                                        • Fertilización ligera post-cosecha
                                        @break
                                    @case(6)
                                        • Proteger de heladas nocturnas<br>
                                        • Reducir riego (cada 4 días)<br>
                                        • Usar cubiertas flotantes
                                        @break
                                    @case(10)
                                        • Siembra de variedades rápidas<br>
                                        • Aumentar riego (cada 1-2 días)<br>
                                        • Controlar hongos por lluvias
                                        @break
                                    @default
                                        • Mantener riego cada 3 días<br>
                                        • Control de plagas periódico<br>
                                        • Monitorear crecimiento
                                @endswitch
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Función para cargar datos meteorológicos
    function loadWeather() {
        fetch('/api/weather/tiquipaya')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const weather = data.data;
                    
                    // Actualizar datos del clima
                    document.getElementById('weather-container').innerHTML = `
                        <div class="col-md-6 text-center">
                            <img src="${weather.icon}" alt="${weather.condition}" width="80">
                            <div class="display-4">${weather.temperature}°C</div>
                            <p class="text-capitalize">${weather.condition}</p>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item">Humedad: ${weather.humidity}%</li>
                                <li class="list-group-item">Lluvia: ${weather.rain} mm/h</li>
                                <li class="list-group-item">Viento: ${weather.wind_speed} km/h</li>
                            </ul>
                        </div>
                    `;
                    
                    // Actualizar marca de tiempo
                    document.getElementById('last-update').textContent = `Actualizado: ${data.last_update}`;
                    
                    // Generar alertas agrícolas
                    updateAlerts(weather);
                }
            })
            .catch(error => {
                console.error("Error al cargar el clima:", error);
                document.getElementById('weather-container').innerHTML = `
                    <div class="alert alert-danger">
                        Error al cargar datos climáticos. Recarga la página.
                    </div>
                `;
            });
        
        // Actualizar cada 5 minutos
        setTimeout(loadWeather, 300000);
    }

    // Función para generar alertas según condiciones climáticas
    function updateAlerts(weather) {
        let alertsHtml = '';
        
        // Alertas por temperatura
        if(weather.temperature < 5) {
            alertsHtml += `
            <div class="alert alert-danger">
                <strong>❄️ Alerta por Heladas</strong><br>
                Temperaturas bajas (${weather.temperature}°C) pueden dañar tus cultivos.<br>
                <u>Acción:</u> Cubrir con mallas térmicas por la noche.
            </div>`;
        } 
        else if(weather.temperature > 25) {
            alertsHtml += `
            <div class="alert alert-warning">
                <strong>☀️ Alerta por Calor Extremo</strong><br>
                Las altas temperaturas pueden estresar las plantas.<br>
                <u>Acción:</u> Aumentar riego en horas tempranas.
            </div>`;
        }
        
        // Alertas por lluvia
        if(weather.rain > 15) {
            alertsHtml += `
            <div class="alert alert-primary">
                <strong>🌧️ Lluvias Intensas</strong><br>
                Precipitación de ${weather.rain} mm puede causar encharcamientos.<br>
                <u>Acción:</u> Verificar drenaje y suspender riego automático.
            </div>`;
        }
        else if(weather.rain == 0 && weather.humidity < 40) {
            alertsHtml += `
            <div class="alert alert-info">
                <strong>⚠️ Condiciones Secas</strong><br>
                Humedad baja (${weather.humidity}%) sin precipitación.<br>
                <u>Acción:</u> Ajustar fertirriego y monitorear estrés hídrico.
            </div>`;
        }
        
        // Si no hay alertas críticas
        if(alertsHtml === '') {
            alertsHtml = `
            <div class="alert alert-success">
                <strong>✅ Condiciones Óptimas</strong><br>
                El clima actual es favorable para el cultivo de lechuga.
            </div>`;
        }
        
        document.getElementById('weather-alerts').innerHTML = alertsHtml;
    }

    // Iniciar la carga del clima
    loadWeather();
});
</script>
@endsection