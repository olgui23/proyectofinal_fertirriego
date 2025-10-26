<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Venta</title>
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
            padding: 20px 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #64A500;
            padding-bottom: 10px;
        }

        .header img {
            width: 80px;
            margin-bottom: 10px;
        }

        .header h1 {
            color: #64A500;
            font-size: 22px;
            margin: 0;
        }

        .header h3 {
            color: #555;
            margin: 5px 0 0 0;
        }

        .info {
            margin-top: 15px;
            line-height: 1.6;
        }

        .info strong {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background-color: #64A500;
            color: #fff;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        tbody tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .total {
            margin-top: 15px;
            text-align: right;
            font-size: 16px;
            font-weight: bold;
            color: #333;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #777;
        }

        .thanks {
            margin-top: 40px;
            text-align: center;
            background-color: #E8F8F5;
            padding: 20px;
            border-radius: 10px;
            border: 1px dashed #6AB04C;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('images/logoFertirriego.png') }}" alt="Logo Fertirriego">
            <h1>COMPROBANTE DE VENTA</h1>
            <h3>Venta #{{ $venta->id }}</h3>
        </div>

        <div class="info">
            <p><strong>Cliente:</strong> {{ $venta->user->nombre_completo ?? 'N/A' }}</p>
            <p><strong>Teléfono:</strong> {{ $venta->telefono_contacto }}</p>
            <p><strong>Fecha:</strong> {{ $venta->fecha_venta->format('d/m/Y H:i') }}</p>
            <p><strong>Tipo de Entrega:</strong> {{ ucfirst($venta->tipo_entrega) }}</p>
            <p><strong>Dirección:</strong> {{ $venta->direccion_envio ?? 'N/A' }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($venta->estado) }}</p>
        </div>

        <h3 style="margin-top:20px; color:#64A500;">Detalles de la compra</h3>
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

        <p class="total">💵 Total: Bs {{ number_format($venta->total, 2) }}</p>

        <div class="thanks">
            <h2>¡Gracias por tu compra! 💚</h2>
            <p>Tu pedido ha sido registrado con éxito. Pronto nos pondremos en contacto contigo para coordinar la entrega.</p>
        </div>
        <div class="footer">
            <p>Sistema de Fertirrigación | {{ date('Y') }}</p>
        </div>
    </div>
</body>
</html>
