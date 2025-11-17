<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Venta</title>

    <style>
        /* TIPOGRAFÍA: estilo Poppins simulada para PDF */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            background: #f4fff4;
            color: #333;
        }

        /* BARRA SUPERIOR SOLO VERDE */
        .top-bar {
            width: 100%;
            background: #64A500; /* Verde solicitado */
            padding: 20px 0 10px 0;
            text-align: center;
            border-bottom: 4px solid #4A7F00;
        }

        /* LOGO CENTRADO Y GRANDE CON FONDO BLANCO */
        .logo-container {
            width: 100%;
            text-align: center;
            background: white;
            padding: 15px 0;
        }

        .logo-container img {
            width: 160px;
        }

        /* TÍTULO PRINCIPAL */
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

        .title h3 {
            margin: 3px 0 0 0;
            font-size: 14px;
            color: #4A7F00;
        }

        /* CONTENEDOR GENERAL */
        .container {
            background: #fff;
            border-radius: 12px;
            padding: 25px 35px;
            margin: 25px;
            border: 1px solid #d8e8d8;
        }

        .info p {
            line-height: 1.6;
            margin: 4px 0;
        }

        .info strong {
            color: #64A500;
        }

        h3.section-title {
            margin-top: 25px;
            color: #64A500;
            border-left: 5px solid #64A500;
            padding-left: 8px;
            font-size: 17px;
            font-weight: bold;
        }

        /* TABLA */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        thead {
            background-color: #64A500;
            color: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #dcecdc;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f3fff3;
        }

        /* TOTAL */
        .total {
            margin-top: 18px;
            text-align: right;
            font-size: 17px;
            font-weight: bold;
            color: #64A500;
        }

        /* MENSAJE FINAL */
        .thanks {
            margin-top: 35px;
            text-align: center;
            background-color: #ECFFE8;
            padding: 18px;
            border-radius: 10px;
            border: 1px dashed #64A500;
        }

        .thanks h2 {
            margin: 0 0 6px;
            color: #64A500;
        }

        /* PIE */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #6b876b;
            border-top: 1px solid #cfe9cf;
            padding-top: 8px;
        }

    </style>
</head>

<body>

    <!-- BARRA SUPERIOR VERDE -->
    <div class="top-bar"></div>

    <!-- LOGO CENTRADO CON FONDO BLANCO -->
    <div class="logo-container">
        <img src="{{ public_path('images/encabezadologo.png') }}" alt="Logo">
    </div>

    <!-- TÍTULO CENTRADO -->
    <div class="title">
        <h1>COMPROBANTE DE VENTA</h1>
        <h3>Venta #{{ $venta->id }}</h3>
    </div>

    <!-- CONTENIDO -->
    <div class="container">

        <div class="info">
            <p><strong>Cliente:</strong> {{ $venta->user->nombre_completo ?? 'N/A' }}</p>
            <p><strong>Teléfono:</strong> {{ $venta->telefono_contacto }}</p>
            <p><strong>Fecha:</strong> {{ $venta->fecha_venta->format('d/m/Y H:i') }}</p>
            <p><strong>Tipo de Entrega:</strong> {{ ucfirst($venta->tipo_entrega) }}</p>
            <p><strong>Dirección:</strong> {{ $venta->direccion_envio ?? 'N/A' }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($venta->estado) }}</p>
        </div>

        <h3 class="section-title">Detalles de la compra</h3>

        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio U.</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta->detalles as $detalle)
                <tr>
                    <td>{{ $detalle->producto->nombre }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>Bs {{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>Bs {{ number_format($detalle->precio_unitario * $detalle->cantidad, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p class="total"> Total: Bs {{ number_format($venta->total, 2) }}</p>

        <div class="thanks">
            <h2>¡Gracias por tu compra! </h2>
            <p>Tu pedido ha sido registrado con éxito.</p>
        </div>

        <div class="footer">
            Sistema de Fertirrigación | {{ date('Y') }}
        </div>

    </div>

</body>
</html>
