<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            background: #f4fff4;
            color: #333;
            line-height: 1.45;
        }

        /* ENCABEZADO VERDE */
        .top-bar {
            width: 100%;
            background: #64A500;
            padding: 20px 0 10px;
            text-align: center;
            border-bottom: 4px solid #4A7F00;
        }

        /* CONTENEDOR DEL LOGO */
        .logo-container {
            width: 100%;
            text-align: center;
            background: #ffffff;
            padding: 15px 0;
        }

        .logo-container img {
            width: 160px;
        }

        /* TÍTULO */
        .title {
            width: 100%;
            text-align: center;
            margin-top: 10px;
        }

        .title h1 {
            font-size: 24px;
            margin: 5px 0 0 0;
            font-weight: bold;
            color: #64A500;
        }

        /* CONTENEDOR GENERAL */
        .container {
            background: white;
            border-radius: 12px;
            padding: 25px 35px;
            margin: 25px;
            border: 1px solid #d8e8d8;
        }

        h3.section-title {
            color: #64A500;
            border-left: 5px solid #64A500;
            padding-left: 8px;
            font-size: 18px;
            margin-top: 35px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 10px;
        }

        thead {
            background-color: #64A500;
            color: white;
        }

        th, td {
            padding: 9px;
            border: 1px solid #dcecdc;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f3fff3;
        }

        /* TOTAL */
        .total {
            text-align: right;
            font-size: 15px;
            font-weight: bold;
            color: #3B5E1A;
            margin-bottom: 20px;
        }

        /* NUMERACIÓN */
        @page {
            margin: 40px;
        }

        footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 11px;
            color: #6b876b;
        }

        .page-number:after {
            content: counter(page);
        }

    </style>
</head>

<body>

    <footer>
        Página <span class="page-number"></span>
    </footer>

    <!-- BARRA VERDE -->
    <div class="top-bar"></div>

    <!-- LOGO -->
    <div class="logo-container">
        <img src="{{ public_path('images/encabezadologo.png') }}">
    </div>

    <!-- TÍTULO PRINCIPAL -->
    <div class="title">
        <h1>REPORTE DE VENTAS</h1>
    </div>
        <!-- DESCRIPCIÓN DEL RANGO DE FECHAS -->
<div style="text-align: center; margin-top: 10px; margin-bottom: 20px; font-size: 14px; color: #3B5E1A;">
    <p>
        A continuación se presentan los reportes de ventas registrados
        @if(!empty($fecha_inicio) && !empty($fecha_fin))
            entre el <strong>{{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }}</strong>
            y el <strong>{{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</strong>.
        @elseif(!empty($fecha_inicio))
            desde el <strong>{{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') }}</strong>.
        @elseif(!empty($fecha_fin))
            hasta el <strong>{{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') }}</strong>.
        @else
            durante el período seleccionado.
        @endif
    </p>
</div>


    <div class="container">

        <!-- ===================== APROBADOS ===================== -->

        <h3 class="section-title">Ventas Aprobadas</h3>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total (Bs.)</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($ventas->where('estado_venta', 'aprobado') as $venta)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $venta->user->nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                        <td>{{ number_format($venta->total, 2) }}</td>
                        <td>{{ ucfirst($venta->estado_venta) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">
            Total Aprobado: Bs 
            {{ number_format($ventas->where('estado_venta', 'aprobado')->sum('total'), 2) }}
        </p>

        <!-- ===================== CANCELADOS ===================== -->

        <h3 class="section-title">Ventas Canceladas</h3>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total (Bs.)</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($ventas->where('estado_venta', 'cancelado') as $venta)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $venta->user->nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                        <td>{{ number_format($venta->total, 2) }}</td>
                        <td>{{ ucfirst($venta->estado_venta) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">
            Total Cancelado: Bs 
            {{ number_format($ventas->where('estado_venta', 'cancelado')->sum('total'), 2) }}
        </p>

        <!-- ===================== PENDIENTES ===================== -->

        <h3 class="section-title">Ventas Pendientes</h3>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total (Bs.)</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @foreach ($ventas->where('estado_venta', 'pendiente') as $venta)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $venta->user->nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                        <td>{{ number_format($venta->total, 2) }}</td>
                        <td>{{ ucfirst($venta->estado_venta) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total">
            Total Pendiente: Bs 
            {{ number_format($ventas->where('estado_venta', 'pendiente')->sum('total'), 2) }}
        </p>

    </div>

</body>
</html>
