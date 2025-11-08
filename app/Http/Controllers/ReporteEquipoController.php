<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteEquipo;
use App\Models\Equipo;

class ReporteEquipoController extends Controller
{
    // Mostrar la vista con equipos y gráfico (panel web)
    public function index()
    {
        $equipos = Equipo::all(); // Obtener todos los equipos
        return view('control.control', compact('equipos'));
    }

    // Obtener datos históricos y último reporte para un equipo (panel web)
    public function datos($equipo_id)
    {
        $historico = ReporteEquipo::where('equipo_id', $equipo_id)
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->pluck('valor')
            ->map(fn($v) => is_numeric($v) ? (float)$v : 0)
            ->reverse()
            ->toArray();

        $ultimo = ReporteEquipo::where('equipo_id', $equipo_id)
            ->latest()
            ->first();

        return response()->json([
            'historico' => $historico,
            'ultimo_reporte' => $ultimo
        ]);
    }

    // Ejecutar acción desde la vista (panel web)
    public function accion(Request $request, $equipo_id)
{
    $request->validate([
        'tipo_accion' => 'required|string'
    ]);

    $tipo = $request->input('tipo_accion');

    // Determinar el estado: 1 = encendido, 0 = apagado
    $estado = 1;
    if (str_contains($tipo, 'parar')) {
        $estado = 0;
    }

    $reporte = ReporteEquipo::create([
        'equipo_id' => $equipo_id,
        'tipo_accion' => $tipo,
        'valor' => null,
        'estado' => $estado
    ]);

    return response()->json(['success' => true, 'reporte' => $reporte]);
}

   // public function accion(Request $request, $equipo_id)
    //{
      //  $request->validate([
      //      'tipo_accion' => 'required|string'
      //  ]);

      //  $tipo = $request->input('tipo_accion');

      //  $reporte = ReporteEquipo::create([
       //     'equipo_id' => $equipo_id,
       //     'tipo_accion' => $tipo,
        //    'valor' => null,
        //    'estado' => 1
       // ]);

       // return response()->json(['success' => true, 'reporte' => $reporte]);
   // }

    // NUEVO: Registrar datos desde Arduino (MAC + humedad)
public function registroDesdeArduino(Request $request)
{
    $request->validate([
        'mac' => 'required|string',
        'valor' => 'required|numeric',
    ]);

    $equipo = Equipo::where('mac', $request->mac)->first();
    if (!$equipo) {
        return response()->json(['error' => 'Equipo no registrado'], 404);
    }

    $reporte = ReporteEquipo::create([
        'equipo_id' => $equipo->id,
        'tipo_accion' => 'lectura_sensor',
        'valor' => $request->valor,
        'estado' => 1,
    ]);

    $ultimoAccion = ReporteEquipo::where('equipo_id', $equipo->id)
        ->whereIn('tipo_accion', ['iniciar_riego','parar_riego','iniciar_fertilizante','parar_fertilizante','pulso_fertilizante'])
        ->latest()
        ->first();

    $respuesta = [
        'success' => true,
        'reporte_id' => $reporte->id,
        'riego' => false,
        'fertilizante' => false,
        'pulso_fertilizante' => false,
    ];

    $humedad = $request->valor;
    $UMBRAL_RIEGO = 1500;

    // Riego automático
    if ($humedad < $UMBRAL_RIEGO) {
        $respuesta['riego'] = true;
    } elseif ($ultimoAccion && strpos($ultimoAccion->tipo_accion,'riego') !== false) {
        $respuesta['riego'] = $ultimoAccion->estado==1;
    }

    // Fertilizante solo por vista
    if($ultimoAccion){
        $tipo = $ultimoAccion->tipo_accion;
        $estado = $ultimoAccion->estado;

        $respuesta['fertilizante'] = strpos($tipo,'fertilizante') !== false && $estado==1;
        $respuesta['pulso_fertilizante'] = $tipo=='pulso_fertilizante' && $estado==1;
    }

    return response()->json($respuesta);
}


}
