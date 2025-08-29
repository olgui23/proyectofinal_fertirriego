<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $rol): Response
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Verificar si el usuario tiene el rol requerido
        $user = Auth::user();
        
        Log::info("Usuario: {$user->id}, Rol: {$user->rol}, Intentando acceder a rol: {$rol}");
        
        if ($user->rol !== $rol) {
            Log::info("Acceso denegado para usuario {$user->id} - Rol incorrecto");
            
            // EN LUGAR de redirigir, mostrar error de permisos
            abort(403, 'No tienes permisos para acceder a esta sección');
        }
        
        Log::info("Acceso permitido para usuario {$user->id}");
        return $next($request);
    }
}
