<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    public function index()
    {
        $sensores = Sensor::all();
        return view('sensores.sensores', compact('sensores'));
    }
}
