<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsistenteController extends Controller
{
    public function index()
    {
        return view('asistente.asistente'); // Cambiado aquí
    }

    public function responder(Request $request)
    {
        $pregunta = $request->input('pregunta');

        // Respuestas simuladas (puedes mejorar o reemplazar por IA luego)
        $respuesta = match (true) {
            str_contains(strtolower($pregunta), 'riego') => 'Recuerda regar tus lechugas temprano por la mañana o al atardecer.',
            str_contains(strtolower($pregunta), 'plaga') => 'Si notas manchas en las hojas, revisa por pulgones o gusanos.',
            str_contains(strtolower($pregunta), 'clima') => 'El clima actual en Tiquipaya es templado. Cuidado con las heladas de madrugada.',
            default => 'Gracias por tu pregunta. Estamos buscando la mejor respuesta para ti.',
        };

        return view('asistente.asistente', compact('pregunta', 'respuesta')); // También cambiado aquí
    }
}
