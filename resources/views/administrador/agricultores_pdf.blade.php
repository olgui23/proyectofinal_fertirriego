<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Agricultores</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            background: #f4fff4;
            color: #333;
        }

        /* BARRA SUPERIOR VERDE */
        .top-bar {
            width: 100%;
            background: #64A500;
            padding: 20px 0 10px 0;
            text-align: center;
            border-bottom: 4px solid #4A7F00;
        }

        /* LOGO CENTRADO */
        .logo-container {
            width: 100%;
            text-align: center;
            background: white;
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

        .title h3 {
            margin: 3px 0 0 0;
            font-size: 14px;
            color: #4A7F00;
        }

        /* CONTENEDOR */
        .container {
            background: #fff;
            border-radius: 12px;
            padding: 25px 35px;
            margin: 25px;
            border: 1px solid #d8e8d8;
        }

        /* TABLA */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #64A500;
            color: white;
        }

        th, td {
            padding: 10px;
            border: 1px solid #dcecdc;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #f3fff3;
        }

        tfoot td {
            font-weight: bold;
            font-size: 14px;
            padding-top: 8px;
            text-align: right;
            color: #64A500;
            border: none;
        }

        /* FOOTER FIJO PARA PAGINACIÓN */
        @page {
            margin: 40px 30px;
        }

        .footer-page {
            position: fixed;
            bottom: -15px;
            left: 0;
            right: 0;
            height: 30px;
            text-align: center;
            font-size: 11px;
            color: #6b876b;
        }

        .footer-page .page:before {
            content: counter(page);
        }

        .footer-page .total-pages:before {
            content: counter(pages);
        }

    </style>
</head>

<body>
    

    <!-- FOOTER FIJO PARA PAGINACIÓN -->
    <div class="footer-page">
        Página <span class="page"></span> de <span class="total-pages"></span>
    </div>

    <!-- BARRA VERDE -->
    <div class="top-bar"></div>

    <!-- LOGO -->
    <div class="logo-container">
        <img src="{{ public_path('images/encabezadologo.png') }}" alt="Logo">
    </div>

    <!-- TÍTULO -->
    <div class="title">
        <h1>LISTADO DE AGRICULTORES</h1>
        <h3>Total registrados: {{ $agricultores->count() }}</h3>
    </div>

    <!-- CONTENIDO -->
    <div class="container">

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

        <div class="footer">
            Sistema de Fertirrigación | {{ date('Y') }}
        </div>

    </div>

</body>
</html>
