<?php

namespace App\Http\Controllers;

use App\Models\Cultivo;
use Illuminate\Http\Request;

class CultivoController extends Controller
{
    public function index()
    {
        $cultivos = Cultivo::all();
        return view('cultivos.cultivos', compact('cultivos'));
    }
}
