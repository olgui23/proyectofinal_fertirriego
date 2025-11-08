<?php

namespace App\Http\Controllers;

use App\Models\ReporteEquipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Riego;      // 🔹 Importa el modelo Riego
use Barryvdh\DomPDF\Facade\Pdf;  // 🔹 Importa la clase PDF (si usas barryvdh/laravel-dompdf)


class RiegoController extends Controller
{
    //public function index()
    //{
    //$riegos = \App\Models\Riego::all();
   // return view('riego.riego', compact('riegos'));
    //}
   public function reporte(Request $request)
{
    $fechaInicio = $request->input('fecha_inicio');
    $fechaFin = $request->input('fecha_fin');

    $query = \App\Models\Riego::query();

    // Si no se envían fechas, mostramos todos
    if ($fechaInicio && $fechaFin) {
        $query->whereBetween('fecha_hora', [$fechaInicio, $fechaFin]);
    }

    $riegos = $query->orderBy('fecha_hora', 'desc')->get();

    return view('control.reporte', compact('riegos', 'fechaInicio', 'fechaFin'));
}
public function reportePDF(Request $request)
{
    $fechaInicio = $request->get('fecha_inicio');
    $fechaFin = $request->get('fecha_fin');

    $query = \App\Models\Riego::query();

    if ($fechaInicio && $fechaFin) {
        $query->whereBetween('fecha_hora', [$fechaInicio, $fechaFin]);
    }

    $riegos = $query->orderBy('fecha_hora', 'asc')->get();

    $user = Auth::user(); // 👈 obtenemos el usuario autenticado

    $pdf = Pdf::loadView('control.reporte_pdf', compact('riegos', 'fechaInicio', 'fechaFin', 'user'))
              ->setPaper('a4', 'portrait');

    return $pdf->stream('reporte_riego.pdf');
}
// Vista del nuevo reporte usando reporte_equipos
// Vista del nuevo reporte usando reporte_equipos
public function reporte2(Request $request)
{
    $fechaInicio = $request->input('fecha_inicio');
    $fechaFin = $request->input('fecha_fin');

    $query = ReporteEquipo::query();

    if ($fechaInicio && $fechaFin) {
        // Si el usuario selecciona fechas, mostramos todos los registros dentro del rango
        $query->whereBetween('created_at', [$fechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);
    } else {
        // Si no se seleccionan fechas, mostramos solo los últimos 20 registros
        $query->orderBy('created_at', 'desc')->limit(20);
    }

    $riegos = $query->orderBy('created_at', 'desc')->get();

    return view('control.reporte2', compact('riegos', 'fechaInicio', 'fechaFin'));
}


// PDF del nuevo reporte
public function reportePDF2(Request $request)
{
    $fechaInicio = $request->get('fecha_inicio') ?? now()->format('Y-m-d');
    $fechaFin    = $request->get('fecha_fin') ?? now()->format('Y-m-d');

    $query = ReporteEquipo::query();
    $query->whereBetween('created_at', [$fechaInicio.' 00:00:00', $fechaFin.' 23:59:59']);

    $riegos = $query->orderBy('created_at', 'asc')->get();
    $user = Auth::user(); // Usuario autenticado

    $pdf = Pdf::loadView('control.reporte_pdf2', compact('riegos', 'fechaInicio', 'fechaFin', 'user'))
              ->setPaper('a4', 'portrait');

    return $pdf->stream('reporte_equipos.pdf');
}


}
