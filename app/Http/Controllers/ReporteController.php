<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
{
    $reportes = \App\Models\Reporte::all();
    return view('reportes.reportes', compact('reportes'));
}

}
