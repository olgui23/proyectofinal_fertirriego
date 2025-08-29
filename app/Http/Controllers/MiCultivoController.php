<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use PDF;

class MiCultivoController extends Controller
{
    public function calendario()
    {
        return view('mi_cultivo.calendario');
    }

    public function reportes()
    {
    $reportes = Reporte::latest()->get();
    return view('mi_cultivo.reportes', compact('reportes'));
    }

    public function guardarReporte(Request $request)
    {
    $validated = $request->validate([
        'fecha_registro' => 'required|date',
        'tipo_lechuga' => 'required|string',
        'superficie' => 'required|numeric',
        'unidad_medida' => 'required|string',
        'etapa_crecimiento' => 'required|string',
        'estado_cultivo' => 'required|string',
        'estacion_anio' => 'required|string',
        'observaciones' => 'nullable|string',
        'foto_cultivo' => 'nullable|image|max:2048',
    ]);

    if ($request->hasFile('foto_cultivo')) {
        $validated['foto_cultivo'] = $request->file('foto_cultivo')->store('fotos', 'public');
    }

    Reporte::create($validated);

    return redirect()->route('miCultivo.reportes')->with('mensaje', 'Reporte guardado correctamente.');
    }

}
