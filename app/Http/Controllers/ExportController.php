<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reporte;
use Barryvdh\DomPDF\Facade\Pdf;



class ExportController extends Controller
{
    public function descargarPDF()
    {
    $reportes = Reporte::all();
    $pdf = Pdf::loadView('mi_cultivo.reportes_pdf', compact('reportes'));
    return $pdf->download('reporte_cultivo.pdf');
    }

}

