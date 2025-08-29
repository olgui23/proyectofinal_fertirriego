<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiegoController extends Controller
{
    public function index()
    {
    $riegos = \App\Models\Riego::all();
    return view('riego.riego', compact('riegos'));
    }

}
