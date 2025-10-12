<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\AgricultorBienvenidaMail;


class AdminController extends Controller
{
    public function agricultores()
    {
        $agricultores = User::where('rol', 'agricultor')->paginate(10);
        return view('administrador.index', compact('agricultores'));
    }

    public function crearAgricultor()
{
    $defaultPassword = 'cambiar123'; // contraseña por defecto
    return view('administrador.create', compact('defaultPassword'));
}


    public function guardarAgricultor(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'username' => 'required|string|unique:users,username',
        'fecha_nacimiento' => 'required|date|before:-18 years',
        'genero' => 'nullable|in:masculino,femenino,otro',
        'foto_perfil' => 'nullable|image|mimes:jpeg,png|max:2048',
    ]);

    // Contraseña por defecto
    $passwordTemporal = '12345678'; // puedes cambiarla o generarla aleatoria

    $user = new User();
    $user->nombre = $request->nombre;
    $user->apellidos = $request->apellidos;
    $user->email = $request->email;
    $user->username = $request->username;
    $user->password = Hash::make($passwordTemporal);
    $user->rol = 'agricultor';
    $user->fecha_nacimiento = $request->fecha_nacimiento;
    $user->genero = $request->genero ?? 'otro';

    if ($request->hasFile('foto_perfil')) {
        $user->foto_perfil = $request->file('foto_perfil')->store('profile_photos', 'public');
    }

    $user->save();

    // Enviar correo de bienvenida con contraseña temporal
    Mail::to($user->email)->send(new AgricultorBienvenidaMail($user, $passwordTemporal));

    return redirect()->route('administrador.index')
                     ->with('success', 'Agricultor registrado correctamente. Se envió un correo con sus datos de acceso.');
}

    public function editarAgricultor($id)
    {
        $agricultor = User::findOrFail($id);
        return view('administrador.edit', compact('agricultor'));
    }

    public function actualizarAgricultor(Request $request, $id)
    {
        $agricultor = User::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|string|unique:users,username,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $agricultor->nombre = $request->nombre;
        $agricultor->apellidos = $request->apellidos;
        $agricultor->email = $request->email;
        $agricultor->username = $request->username;

        if ($request->filled('password')) {
            $agricultor->password = Hash::make($request->password);
        }

        $agricultor->save();

        return redirect()->route('administrador.index')->with('success', 'Agricultor actualizado correctamente.');
    }

    public function eliminarAgricultor($id)
    {
        $agricultor = User::findOrFail($id);
        $agricultor->delete();

        return redirect()->route('administrador.index')->with('success', 'Agricultor eliminado correctamente.');
    }
    public function userRolesData()
    {
    $roles = \App\Models\User::select('rol', DB::raw('count(*) as total'))
                ->groupBy('rol')
                ->pluck('total', 'rol');

    return response()->json([
        'roles' => $roles->keys(),
        'counts' => $roles->values()
    ]);
    }

  public function exportPdf()
{
    // Traer solo usuarios con rol 'agricultor' (ajusta la condición según tu DB)
    $agricultores = User::where('rol', 'agricultor')->get();

    $pdf = Pdf::loadView('administrador.agricultores_pdf', compact('agricultores'));

    return $pdf->download('agricultores.pdf');
}

 public function viewPdf()
{
    $agricultores = User::where('rol', 'agricultor')->get(); // ajusta según tu filtro

    $pdf = Pdf::loadView('administrador.agricultores_pdf', compact('agricultores'));

    // Generar contenido PDF como base64 para mostrar inline
    $pdfContent = base64_encode($pdf->output());

    return view('administrador.agricultores_pdf_view', compact('pdfContent'));
}

public function downloadPdf()
{
    $agricultores = User::where('rol', 'agricultor')->get();

    $pdf = Pdf::loadView('administrador.agricultores_pdf', compact('agricultores'));

    return $pdf->download('agricultores.pdf');
}

}
