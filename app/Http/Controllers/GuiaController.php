<?php

namespace App\Http\Controllers;

class GuiaController extends Controller
{
    public function variedades()
    {
        return view('guia.variedades');
    }

    public function plagas()
    {
        return view('guia.plagas');
    }

    public function salud()
    {
        return view('guia.salud');
    }

    public function practicas()
    {
        return view('guia.practicas');
    }
}

