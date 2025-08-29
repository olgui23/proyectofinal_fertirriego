<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    public function index()
{
    $configuraciones = \App\Models\Configuracion::all();
    return view('configuracion.configuracion', compact('configuraciones'));
}
}
