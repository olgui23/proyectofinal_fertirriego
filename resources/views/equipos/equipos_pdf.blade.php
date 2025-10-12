<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Listado de Equipos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 25px 40px;
            font-size: 13px;
            color: #2e7d32; /* verde oscuro */
            background-color: #f0fff0; /* verde muy claro */
        }
        header {
            border-bottom: 3px solid #4caf50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            text-align: center;
        }
        header h1 {
            color: #4caf50;
            margin: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
            box-shadow: 0 0 8px rgba(76,175,80,0.15);
            background: white;
            border-radius: 5px;
            overflow: hidden;
        }
        thead {
            background-color: #4caf50;
            color: white;
            font-weight: 600;
        }
        th, td {
            padding: 10px 12px;
            border: 1px solid #c8e6c9;
            text-align: left;
        }
        tbody tr:nth-child(even) {
            background-color: #e8f5e9;
        }
        footer {
            font-size: 11px;
            text-align: center;
            color: #789262;
            border-top: 1px solid #c8e6c9;
            padding-top: 8px;
            position: fixed;
            bottom: 20px;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Listado de Equipos de Monitoreo</h1>
    </header>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>MAC</th>
                <th>Usuario</th>
                <th>Ubicación</th>
                <th>Lat/Lng</th>
                <th>Fecha Instalación</th>
                <th>Activo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($equipos as $equipo)
            <tr>
                <td>{{ $equipo->id }}</td>
                <td>{{ $equipo->mac }}</td>
                <td>{{ optional($equipo->user)->name ?? 'N/A' }}</td>
                <td>{{ $equipo->ubicacion ?? 'N/A' }}</td>
                <td>{{ $equipo->lat ?? '-' }}, {{ $equipo->lng ?? '-' }}</td>
                <td>{{ $equipo->fecha_instalacion ?? 'N/A' }}</td>
                <td>{{ $equipo->activo ? 'Sí' : 'No' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">Total de Equipos: {{ $equipos->count() }}</td>
            </tr>
        </tfoot>
    </table>

    <footer>
        Generado por Sistema de Gestión - {{ date('d/m/Y') }}
    </footer>
</body>
</html>
