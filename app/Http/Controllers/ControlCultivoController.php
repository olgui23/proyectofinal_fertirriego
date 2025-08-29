<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControlCultivoController extends Controller
{
    public function index()
    {
        // Datos simulados de sensores
        $datos = [
            'humedad' => 45, // en porcentaje
            'ph' => 6.8,
            'temperatura' => 22, // grados Celsius
            'estadoRiego' => 'Apagado'
        ];

        return view('control.control', compact('datos')); // ✅ Cambiado al nuevo nombre
    }

    public function activarRiego()
    {
        // Aquí podrías integrar la lógica real del microcontrolador
        return back()->with('mensaje', 'Riego automático activado.');
    }
}
