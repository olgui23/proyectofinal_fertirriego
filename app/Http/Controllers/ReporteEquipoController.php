<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReporteEquipo;
use App\Models\Equipo;

class ReporteEquipoController extends Controller
{
    // Mostrar la vista con equipos y gráfico
    public function index()
    {
        $equipos = Equipo::all(); // Obtener todos los equipos
        return view('control.control', compact('equipos'));
    }

    // Obtener datos históricos y último reporte para un equipo
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

    // Ejecutar acción desde la vista
    public function accion(Request $request, $equipo_id)
    {
        $request->validate([
            'tipo_accion' => 'required|string'
        ]);

        $tipo = $request->input('tipo_accion');

        $reporte = ReporteEquipo::create([
            'equipo_id' => $equipo_id,
            'tipo_accion' => $tipo,
            'valor' => null,
            'estado' => 1
        ]);

        return response()->json(['success' => true, 'reporte' => $reporte]);
    }
}
