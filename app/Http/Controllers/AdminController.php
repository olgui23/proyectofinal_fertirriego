<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
{
    // Contar usuarios agrupados por rol
    $userRoles = User::select('rol', DB::raw('count(*) as total'))
        ->groupBy('rol')
        ->pluck('total', 'rol'); // Ej: ['admin' => 3, 'agricultor' => 5, ...]

    return view('dashboard_admin', compact('userRol'));
}
}
