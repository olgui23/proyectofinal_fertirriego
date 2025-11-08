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

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 11px;
            color: #777;
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

        {{-- 1. Resultados de Humedad del Suelo --}}
        <h2>1. Resultados de Humedad del Suelo</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Fecha</th>
                    <th>Inicio de Riego</th>
                    <th>Fin de Riego</th>
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
                        <td>{{ \Carbon\Carbon::parse($riego->created_at)->format('d/m/Y H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($riego->created_at)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($riego->updated_at)->format('H:i') }}</td>
                        <td>{{ $riego->valor }}</td>
                        <td>{{ $riego->valor ? round(($riego->valor / 4095) * 100, 2) : 0 }}%</td>
                        <td>{{ $riego->estado == 1 ? 'Activo' : 'Finalizado' }}</td>
                        <td>{{ ucfirst(str_replace('_',' ',$riego->tipo_accion)) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8">No se registraron datos durante el periodo seleccionado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @php
            $promedio = count($riegos) > 0 ? round(collect($riegos)->avg(fn($r) => ($r->valor / 4095) * 100), 2) : null;
        @endphp

        @if($promedio)
            <p><strong>Promedio semanal de humedad:</strong> {{ $promedio }} %</p>
        @endif

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
