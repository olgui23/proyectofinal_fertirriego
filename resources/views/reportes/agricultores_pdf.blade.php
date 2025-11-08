<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Agricultores</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');

        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 30px 40px;
            color: #2f4f2f; /* verde oscuro */
            font-size: 13px;
            background-color: #f0fff0; /* verde muy claro */
        }
        header {
            border-bottom: 3px solid #4caf50; /* verde vibrante */
            margin-bottom: 25px;
            padding-bottom: 10px;
            text-align: center;
        }
        header h1 {
            margin: 0;
            color: #4caf50;
            font-weight: 700;
            font-size: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 0 10px rgba(76,175,80,0.2);
            background: white;
            border-radius: 5px;
            overflow: hidden;
        }
        thead {
            background-color: #4caf50;
            color: #fff;
            font-weight: 600;
        }
        th, td {
            padding: 12px 15px;
            border: 1px solid #c8e6c9;
            text-align: left;
        }
        tbody tr:nth-child(even) {
            background-color: #e8f5e9;
        }
        tfoot td {
            font-weight: 700;
            font-size: 14px;
            padding-top: 10px;
            border: none;
            color: #2e7d32;
        }
        footer {
            position: fixed;
            bottom: 30px;
            width: 100%;
            font-size: 11px;
            text-align: center;
            color: #789262;
            border-top: 1px solid #c8e6c9;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Listado de Agricultores Registrados</h1>
    </header>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Completo</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Género</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agricultores as $agricultor)
            <tr>
                <td>{{ $agricultor->id }}</td>
                <td>{{ $agricultor->nombre }} {{ $agricultor->apellidos }}</td>
                <td>{{ $agricultor->username }}</td>
                <td>{{ $agricultor->email }}</td>
                <td>{{ ucfirst($agricultor->genero) }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5">Total de Agricultores: {{ $agricultores->count() }}</td>
            </tr>
        </tfoot>
    </table>

    <footer>
        Generado por Sistema de Gestión - {{ date('d/m/Y') }}
    </footer>
</body>
</html>
