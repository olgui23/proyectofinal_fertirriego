<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Informe Final - Estado del Cultivo</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 30px;
            background-color: #f9f9f9;
        }

        .container {
            background: #fff;
            border-radius: 12px;
            padding: 25px 35px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #64A500;
            padding-bottom: 10px;
        }

        .header img {
            width: 90px;
            margin-bottom: 10px;
        }

        .header h1 {
            color: #64A500;
            font-size: 22px;
            margin: 0;
        }

        .header h3 {
            color: #555;
            margin-top: 5px;
        }

        .info {
            margin-top: 15px;
            line-height: 1.6;
        }

        .info strong {
            color: #333;
        }

        h2 {
            color: #64A500;
            font-family: 'Merriweather', serif;
            font-weight: 700;
            margin-top: 25px;
            margin-bottom: 10px;
            border-left: 4px solid #64A500;
            padding-left: 8px;
        }

        p { text-align: justify; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background-color: #64A500;
            color: #fff;
        }

        th, td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        ul {
            margin-top: 5px;
        }

        li {
            margin-bottom: 6px;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }

        .highlight {
            font-weight: bold;
            color: #64A500;
        }

        .thanks {
            margin-top: 25px;
            text-align: center;
            background-color: #E8F8F5;
            padding: 18px;
            border-radius: 10px;
            border: 1px dashed #6AB04C;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- ENCABEZADO --}}
        <div class="header">
            <img src="{{ public_path('images/logoFertirriego.png') }}" alt="Logo Fertirriego">
            <h1>INFORME FINAL – Estado del Cultivo de Lechuga</h1>
            <h3>Semana de evaluación: {{ $fechaInicio ?? '—' }} al {{ $fechaFin ?? '—' }}</h3>
        </div>

        {{-- INFORMACIÓN GENERAL --}}
        <div class="info">
            <p><strong>Proyecto:</strong> Sistema de fertirrigación automatizado</p>
            <p><strong>Ubicación:</strong> Parcela experimental – Prototipo de riego</p>
            <p><strong>Elaborado por:</strong> {{ $user->nombre_completo ?? 'Usuario del sistema' }}</p>

            <p><strong>Fecha de informe:</strong> {{ now()->format('d/m/Y') }}</p>
        </div>

        {{-- 🌿 1. Introducción --}}
        <h2> 1. Introducción</h2>
        <p>
            Durante la semana de evaluación se monitoreó el comportamiento de la humedad del suelo en el cultivo de lechuga mediante un sensor de humedad calibrado 
            (Valor seco: 3000, Valor húmedo: 800). 
            El objetivo fue determinar la eficiencia del sistema de riego automático y la respuesta del cultivo bajo la aplicación de fertilizante soluble a través del sistema de fertirrigación.
        </p>

        {{-- 💧 2. Resultados --}}
        <h2> 2. Resultados de Humedad del Suelo</h2>

        <table>
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Inicio de Riego</th>
                    <th>Fin de Riego</th>
                    <th>Lectura ADC</th>
                    <th>Humedad (%)</th>
                    <th>Estado del Suelo</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riegos as $riego)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($riego->fecha_hora)->format('d/m/Y') }}</td>
                        <td>{{ $riego->inicio }}</td>
                        <td>{{ $riego->fin }}</td>
                        <td>{{ $riego->lectura_adc }}</td>
                        <td>{{ $riego->humedad }}%</td>
                        <td>{{ $riego->estado }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">No se registraron datos durante el periodo seleccionado.</td></tr>
                @endforelse
            </tbody>
        </table>

        @php
            $promedio = count($riegos) > 0 ? round($riegos->avg('humedad'), 2) : null;
        @endphp

        @if($promedio)
            <p><strong>Promedio semanal:</strong> {{ $promedio }} %</p>
        @endif

        <p>
            <strong>Interpretación:</strong>
            Los niveles de humedad se mantuvieron por debajo del umbral óptimo (50–80%), indicando déficit de humedad en el sustrato. 
            Esto sugiere que el tiempo o la frecuencia del riego no fueron suficientes para alcanzar la humedad ideal requerida por la lechuga.
        </p>

        {{-- 🌾 3. Estado del Cultivo --}}
        <h2>3. Estado del Cultivo</h2>
        <p>
            Durante la observación visual, las plantas mostraron crecimiento moderado, con hojas de color verde claro y bordes ligeramente deshidratados.
            No se evidenció marchitamiento severo ni presencia de plagas.
        </p>
        <p><strong>Conclusión parcial:</strong> El estrés hídrico leve puede estar afectando el vigor vegetativo, por lo que se recomienda aumentar la frecuencia del riego.</p>

        {{-- 🧪 4. Estado del Fertilizante --}}
        <h2>4. Estado del Fertilizante</h2>
        <table>
            <thead>
                <tr>
                    <th>Parámetro</th>
                    <th>Valor observado</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>Conductividad eléctrica (EC)</td><td>1.8 mS/cm</td><td>Adecuada</td></tr>
                <tr><td>pH del agua fertilizada</td><td>6.4</td><td>Óptimo</td></tr>
                <tr><td>Frecuencia de aplicación</td><td>3 veces/semana</td><td>Acorde al plan</td></tr>
                <tr><td>Absorción observada</td><td>Normal</td><td>Sin acumulación de sales</td></tr>
            </tbody>
        </table>
        <p>
            <strong>Interpretación:</strong>
            El fertilizante se mantuvo en rango adecuado de concentración y pH, asegurando buena disponibilidad de nutrientes. 
            Sin embargo, la baja humedad del suelo puede limitar la absorción completa de los nutrientes, reduciendo la eficiencia del fertirriego.
        </p>

        {{-- ⚙️5. Conclusiones --}}
        <h2>5. Conclusiones Generales</h2>
        <ul>
            <li>El sistema de riego funcionó correctamente en cuanto a activación y tiempos, pero el volumen de agua no fue suficiente para mantener la humedad óptima.</li>
            <li>Se detecta estrés hídrico leve, lo que podría afectar el rendimiento si no se corrige.</li>
            <li>El fertilizante NPK 20-20-20 mantuvo un comportamiento adecuado, sin sobredosificación.</li>
            <li>Se recomienda ajustar los tiempos de riego y recalibrar el sensor de humedad.</li>
        </ul>

        {{-- Cierre --}}
        <div class="thanks">
            <h3>🌱 Gracias por utilizar el Sistema de Fertirriego Automatizado</h3>
            <p>Este informe ha sido generado automáticamente con base en los datos registrados por el sistema.</p>
        </div>

        <div class="footer">
            <p>Sistema de Fertirrigación Automatizado | © {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
