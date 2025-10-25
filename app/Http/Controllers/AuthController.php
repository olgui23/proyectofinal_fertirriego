<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Services\LoggerSingleton;

class AuthController extends Controller
{
    protected $logger;
    public function __construct(LoggerSingleton $logger)
    {
        $this->middleware('guest')->except('logout');
        $this->logger = $logger;
    }

    // Mostrar formulario de login
    public function showHome()
{
    return view('inicio'); // ← Aquí cargas la vista que hiciste
}

   
   
    public function showLoginForm()
    {
        return view('auth.login');
    }
    

    public function login(Request $request)
    {
        // Validar rate limiting (protección contra fuerza bruta)
        $this->checkTooManyFailedAttempts($request);
        // Validación de credenciales
        $credentials = $request->validate([
            'login' => 'required|string|max:255',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&]/',
        ], [
            'login.required' => 'El nombre de usuario o email es obligatorio',
            'login.max' => 'El usuario/email no puede exceder 255 caracteres',
            'password.required' => 'La contraseña es obligatoria',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
        ]);
        // Validación adicional de formato
        $this->validateLoginFormat($request);
        // Determinar si el login es email o username
        $field = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        // Verificar si el usuario existe
        $user = \App\Models\User::where($field, $credentials['login'])->first();
        // Validar credenciales
        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            RateLimiter::hit($this->throttleKey($request), 120);
            
            throw ValidationException::withMessages([
                'login' => 'Las credenciales no coinciden con nuestros registros.',
            ]);
        }
        // Verificar si el usuario está activo
        if (isset($user->estado) && $user->estado != 1) {
            throw ValidationException::withMessages([
                'login' => 'Tu cuenta está desactivada. Contacta al administrador.',
            ]);
        }
        // VERIFICAR SI EL EMAIL ESTÁ CONFIRMADO
        if (!$user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'login' => 'Debes verificar tu dirección de email antes de iniciar sesión. 
                            <a href="' . route('verification.resend') . '" class="alert-link">Reenviar email de verificación</a>',
            ])->errorBag('email_verification');
        }        

        // Intentar autenticación
        if (Auth::attempt([$field => $credentials['login'], 'password' => $credentials['password']], $request->remember)) {
            $request->session()->regenerate();
            
            // Limpiar intentos fallidos
            RateLimiter::clear($this->throttleKey($request));
            
            // Registrar el login exitoso
            $this->logger->log("Inicio de sesión exitoso. Usuario:" . $user->username . ", usuario: " . $user->rol);
            /*activity()
                ->causedBy($user)
                ->log('Inició sesión en el sistema');
            */
            // Redireccionar según el rol
            return $this->redirectByRole($user);
        }

        throw ValidationException::withMessages([
            'login' => 'Error durante la autenticación. Intenta nuevamente.',
        ]);
    }

    // Método para redireccionar según el rol
    protected function redirectByRole($user)
    {
        $this->logger->log("Redireccionamiento según el rol del usuario:" . $user->rol);
        $redirectTo = match($user->rol) {
            'administrador' => route('admin.dashboard'),
            'agricultor' => route('farm.dashboard'),
            'comprador' => route('buyer.dashboard'),
            default => route('dashboard')
        };

        return redirect()->intended($redirectTo)
            ->with('success', '¡Bienvenido de nuevo, ' . $user->name . '!');
    }

    // Validación de formato del login
    protected function validateLoginFormat(Request $request)
    {
        $login = $request->login;
        
        // Si parece ser un email, validar formato de email
        if (str_contains($login, '@')) {
            $request->validate([
                'login' => 'email:rfc,dns',
            ], [
                'login.email' => 'El formato del email no es válido.',
            ]);
        } else {
            // Validar formato de username
            $request->validate([
                'login' => 'regex:/^(?!admin$)[a-zA-Z0-9_-]{3,20}$/',
                           'not_regex:/@/',
            ], [
                'login.regex' => 'El usuario debe tener entre 3-20 caracteres y solo puede contener letras, números, guiones y puntos.',
            ]);
        }
    }

    // Métodos para rate limiting
    protected function checkTooManyFailedAttempts(Request $request)
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'login' => "Demasiados intentos fallidos. Por favor intenta en {$seconds} segundos.",
        ]);
    }

    protected function throttleKey(Request $request)
    {
        return Str::transliterate(Str::lower($request->input('login')).'|'.$request->ip());
    }



    // Mostrar formulario de registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Procesar registro (optimizado)
    public function register(Request $request)
    {
        $validatedData = $this->validateRegistration($request);
        $user = $this->createUser($validatedData, $request);

        //Enviar email de verificación
        event(new Registered($user));

        try {
            // Enviar email de verificación
            event(new Registered($user));
                           
        } catch (\Exception $e) {
            // Si hay error al enviar email, eliminar el usuario creado
            $user->delete();
            
            return back()->withErrors([
                'email' => 'Error al enviar el email de verificación. Inténtalo de nuevo.'
            ])->withInput();
        };
        return redirect()->route('login')
            ->with('success', '¡Registro exitoso! Por favor, verifica tu email antes de iniciar sesión.');

    }

    public function showVerificationNotice()
{
    return view('auth.verify');
}

public function resendVerification(Request $request)
{
    if ($request->user()->hasVerifiedEmail()) {
        return $this->redirectByRole($request->user());
    }

    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', '¡Enlace de verificación reenviado!');
}


    // Cerrar sesión
    public function logout(Request $request)
    {
        $name = Auth::user()->nombre ?? 'Usuario';
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/home')
            ->with('status', "¡Hasta pronto, $name! Has cerrado sesión correctamente");
    }

    /**
     * Validar datos de registro
     */
    protected function validateRegistration(Request $request): array
{
    return $request->validate([
        'nombre' => 'required|string|max:100',
        'apellidos' => 'required|string|max:100',
        'username' => 'required|string|min:3|max:30|unique:users|regex:/^[a-zA-Z0-9_]+$/',
        'email' => 'required|email|max:100|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'fecha_nacimiento' => 'required|date|before:-18 years', // obligatorio y >18 años
        'genero' => 'nullable|in:masculino,femenino,otro',
        'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg|max:2048|dimensions:max_width=2000,max_height=2000',
    ], [
        'fecha_nacimiento.before' => 'Debes ser mayor de 18 años para registrarte.',
        'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
        'password.confirmed' => 'Las contraseñas no coinciden.',
    ]);
}

    /**
     * Mensajes de validación personalizados
     */
    protected function validationMessages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio',
            'apellidos.required' => 'Los apellidos son obligatorios',
            'username.required' => 'El nombre de usuario es obligatorio',
            'username.unique' => 'Este nombre de usuario ya está registrado',
            'username.regex' => 'Solo se permiten letras, números y guiones bajos',
            'email.required' => 'El email es obligatorio',
            'email.unique' => 'Este email ya está registrado',
            'password.min' => 'La contraseña debe tener al menos 4 caracteres',
            'password.confirmed' => 'Las contraseñas no coinciden',
            'fecha_nacimiento.before' => 'Debes ser mayor de 18 años',
            'foto_perfil.image' => 'El archivo debe ser una imagen válida',
            'foto_perfil.max' => 'La imagen no debe superar los 2MB',
            'foto_perfil.dimensions' => 'La imagen es demasiado grande (máx. 2000x2000px)'
        ];
    }

    /**
     * Crear nuevo usuario
     */
    protected function createUser(array $data, Request $request): User
{
    $userData = [
        'nombre' => $data['nombre'],
        'apellidos' => $data['apellidos'],
        'fecha_nacimiento' => $data['fecha_nacimiento'], // ya validado
        'genero' => $data['genero'] ?? 'otro',
        'username' => $data['username'],
        'email' => $data['email'],
        'password' => bcrypt($data['password']), // siempre hashea la contraseña
        'rol' => 'comprador',
    ];

    if ($request->hasFile('foto_perfil')) {
        $userData['foto_perfil'] = $request->file('foto_perfil')->store('profile_photos', 'public');
    }

    return User::create($userData);
}
    public function profile()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            // otros campos...
        ]);
        //$user->update([]);

        return redirect()->route('profile.edit')
            ->with('success', 'Perfil actualizado correctamente');
    }    
    /**
 * Campo a usar para login.
 *
 * @return string
 */
public function username()
{
    return 'login'; // este es el nombre del input, no del campo de la DB
}

}