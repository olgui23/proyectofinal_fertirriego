<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { color: #64A500; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #64A500; color: white; }
    </style>
</head>
<body>
    <h2>Reporte de Ventas</h2>
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
            @foreach ($ventas as $index => $venta)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $venta->user->nombre }}</td>
                    <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                    <td>{{ number_format($venta->total, 2) }}</td>
                    <td>{{ ucfirst($venta->estado_venta) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>Total de ventas mostradas:</strong> {{ $ventas->count() }}</p>
</body>
</html>
