<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class PerfilController extends Controller
{
    /**
     * Mostrar formulario de edición de perfil.
     */
    public function edit()
    {
        $user = auth()->user();

        // Asegurar formato correcto para el input type="date"
        if ($user->fecha_nacimiento) {
            $user->fecha_nacimiento = \Carbon\Carbon::parse($user->fecha_nacimiento)->format('Y-m-d');
        }

        return view('perfil.edit', compact('user'));
    }

    /**
     * Guardar cambios del perfil.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'fecha_nacimiento' => 'nullable|date|before:' . now()->subYears(18)->format('Y-m-d'),
            'genero' => 'nullable|in:masculino,femenino,otro',
            'username' => 'required|string|max:20|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png|max:2048',
        ]);

        // Actualizar campos
        $user->nombre = $request->nombre;
        $user->apellidos = $request->apellidos;
        $user->fecha_nacimiento = $request->fecha_nacimiento;
        $user->genero = $request->genero;
        $user->username = $request->username;
        $user->email = $request->email;

        // Cambiar contraseña si se ingresó una nueva
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Subir nueva foto si se proporcionó
        if ($request->hasFile('foto_perfil')) {
            // Borrar la anterior si existe
            if ($user->foto_perfil && Storage::exists($user->foto_perfil)) {
                Storage::delete($user->foto_perfil);
            }

            $path = $request->file('foto_perfil')->store('fotos_perfil', 'public');
            $user->foto_perfil = $path;
        }

        /** @var \App\Models\User $user */
        $user->save();

        // Obtener la ruta de dashboard según el rol
        $rol = $user->rol;

        $dashboardRoute = match ($rol) {
            'administrador' => route('admin.dashboard'),
            'agricultor'    => route('farm.dashboard'),
            'comprador'     => route('buyer.dashboard'),
            default         => route('dashboard'),
        };

        // Redirigir a la misma vista con success + ruta del dashboard en la sesión
        return redirect()
            ->route('perfil.edit')
            ->with('success', 'Tu perfil fue actualizado correctamente 🎉')
            ->with('dashboard_redirect', $dashboardRoute);
    }
}
