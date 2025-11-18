<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4fff4;
        }

        /* --------------------- PORTADA --------------------- */
        .portada {
            text-align: center;
            padding-top: 120px;
        }

        .portada img {
            width: 220px;
            margin-bottom: 20px;
        }

        .titulo-portada {
            font-size: 32px;
            color: #64A500;
            margin-top: 20px;
            font-weight: bold;
        }

        .subtitulo-portada {
            font-size: 18px;
            color: #4A7F00;
            margin-top: 10px;
        }

        .stock-portada {
            font-size: 16px;
            margin-top: 15px;
            color: #333;
        }

        /* Barra verde superior */
        .top-bar {
            width: 100%;
            background: #64A500;
            padding: 20px 0;
            border-bottom: 4px solid #4A7F00;
        }

        /* Logo */
        .logo-container {
            width: 100%;
            text-align: center;
            background: white;
            padding: 12px 0;
        }

        .logo-container img {
            width: 150px;
        }

        /* Título */
        h1 {
            text-align: center;
            color: #64A500;
            margin: 10px 0 0 0;
            font-size: 24px;
        }

        .fecha {
            text-align: center;
            font-size: 13px;
            color: #4A7F00;
        }

        /* CATÁLOGO EN TABLA 2 COLUMNAS */
        table.catalogo {
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px 20px;
            margin: 25px;
        }

        td {
            vertical-align: top;
            width: 50%;
        }

        /* Tarjeta */
        .card {
            background: #ffffff;
            border: 1px solid #d8e8d8;
            border-radius: 10px;
            padding: 10px;
        }

        .card img {
    width: 100%;
    max-height: 180px; /* altura máxima */
    object-fit: contain; /* evita estiramiento, se ajusta proporcionalmente */
    border-radius: 8px;
    margin-bottom: 8px;
}


        .card h3 {
            margin: 5px 0;
            color: #64A500;
            font-size: 16px;
            font-weight: bold;
        }

        .price {
            color: #2b7a0b;
            font-weight: bold;
            margin: 4px 0;
        }

        .text {
            font-size: 12px;
            margin: 3px 0;
            color: #555;
        }

        .farmer {
            font-size: 12px;
            margin-top: 5px;
            color: #4A7F00;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <!-- =================== PORTADA =================== -->
    <!-- =================== PORTADA =================== -->
<div class="portada" style="position: relative; text-align: center; height: 100vh; background: #f4fff4;">

    <!-- Logo arriba -->
    <div style="padding-top: 40px;">
        <img src="{{ public_path('images/encabezadologo.png') }}" alt="Logo" style="width: 180px;">
    </div>

    <!-- Título grande centrado -->
    <div style="font-size: 48px; font-weight: bold; color: #64A500; margin-top: 40px;">
        CATÁLOGO DE PRODUCTOS
    </div>

    <!-- Fecha y stock -->
    <div style="font-size: 18px; color: #4A7F00; margin-top: 20px;">
        Fecha de generación: <strong>{{ $fecha_impresion }}</strong>
    </div>

    <div style="font-size: 18px; color: #333; margin-top: 10px;">
        Stock disponible al momento: <strong>{{ $stock_total }} productos</strong>
    </div>

    <!-- Imagen ocupando mitad inferior -->
    <div style="position: absolute; bottom: 0; width: 100%; height: 50%;">
        <img src="{{ public_path('images/slide1.jpg') }}" alt="Portada" style="width: 100%; height: 100%; object-fit: cover;">
    </div>
</div>




    <!-- Salto de página -->
    <div style="page-break-after: always;"></div>

    <!-- =================== CABECERA DE CADA PÁGINA =================== -->
    <div class="top-bar"></div>
    <div class="logo-container">
        <img src="{{ public_path('images/encabezadologo.png') }}" alt="Logo">
    </div>

    <h1>Catálogo de Productos</h1>
    <p class="fecha">Actualizado al: <strong>{{ $fecha_impresion }}</strong></p>


    <!-- =================== CATÁLOGO =================== -->
    <table class="catalogo">
        @foreach ($productos->chunk(2) as $fila)
            <tr>
                @foreach ($fila as $p)
                    <td>
                        <div class="card">
                            <img src="{{ public_path($p->image_url) }}" alt="Producto">

                            <h3>{{ $p->nombre }}</h3>

                            <p class="price">Bs. {{ number_format($p->precio, 2) }} / {{ $p->unidad }}</p>

                            <p class="text">
                                {{ Str::limit($p->descripcion, 100) }}
                            </p>
                            <!-- STOCK DISPONIBLE -->
    <p class="text">
        Stock disponible: <strong>{{ $p->stock }}</strong>
    </p>
                            <p class="farmer">
                                Agricultor: {{ $p->user->nombre_completo }}
                            </p>
                        </div>
                    </td>
                @endforeach

                @if ($fila->count() == 1)
                    <td></td>
                @endif
            </tr>
        @endforeach
    </table>


    <!-- =================== NÚMEROS DE PÁGINA =================== -->
    <script type="text/php">
    if (isset($pdf)) {
        $pdf->page_text($pdf->get_width() - 100, $pdf->get_height() - 30, 
            "Página {PAGE_NUM} de {PAGE_COUNT}", "DejaVu Sans", 9, array(0,0,0));
    }
</script>


</body>
</html>
