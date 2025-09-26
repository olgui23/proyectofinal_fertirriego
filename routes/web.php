<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CultivoController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\RiegoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MiCultivoController;
use App\Http\Controllers\GuiaController;
use App\Http\Controllers\AsistenteController;
use App\Http\Controllers\ControlCultivoController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VentaController;

Route::middleware(['auth'])->group(function () {
    Route::post('/comprar', [VentaController::class, 'store'])->name('ventas.store');
});

use App\Models\User;
use Illuminate\Auth\Events\Verified;
// haber sida 
use Illuminate\Foundation\Auth\EmailVerificationRequest;

// Verificación de email
Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])
    ->middleware('auth')
    ->name('verification.notice');

use App\Http\Controllers\ProductoController;

// Ruta pública para productos
Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');




Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // Marca el email como verificado automáticamente
    return redirect()->route('dashboard')
        ->with('success', '¡Email verificado correctamente! Ya puedes iniciar sesión.');
})->middleware(['auth', 'signed'])->name('verification.verify');

// Reenvío de email
Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');


// Rutas públicas (sin autenticación)
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showHome'])->name('home');
    Route::get('/home', [AuthController::class, 'showHome'])->name('home');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Rutas de verificación de email
Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])
    ->middleware('auth')
    ->name('verification.notice');


Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::find($id);
    
    if (!$user) {
        return redirect()->route('login')
            ->with('error', 'Usuario no encontrado.');
    }
    
    if (!hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        return redirect()->route('login')
            ->with('error', 'Enlace de verificación inválido.');
    }
    
    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')
            ->with('info', 'El email ya ha sido verificado.');
    }
    
    if ($user->markEmailAsVerified()) {
        event(new Verified($user));
    }
    
    return redirect()->route('login')
        ->with('success', '¡Email verificado correctamente! Ya puedes iniciar sesión.');
})->middleware(['signed'])->name('verification.verify');





Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.resend');

// Rutas protegidas (requieren autenticación)
Route::middleware(['auth', 'verified'])->group(function () {
        
    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard_admin', [DashboardController::class, 'adminDashboard'])
        ->middleware('rol:administrador')
        ->name('admin.dashboard');
        
    Route::get('/admin/dashboard/stats', [DashboardController::class, 'dashboardStats'])
            ->name('admin.dashboard.stats');        

    Route::get('/dashboard_farm', [DashboardController::class, 'farmDashboard'])
        ->middleware('rol:agricultor')
        ->name('farm.dashboard');

    Route::get('/dashboard_buyer', [DashboardController::class, 'buyerDashboard'])
        ->middleware('rol:comprador')
        ->name('buyer.dashboard');

    // Rutas para agregar PRODUCTOS
    Route::get('/productos/crear', [ProductoController::class, 'crear'])->name('productos.crear');
    Route::post('/productos', [ProductoController::class, 'guardar'])->name('productos.guardar');
    

    
    // Rutas de Mi Cultivo
    Route::prefix('mi-cultivo')->group(function () {
        Route::get('/reportes', [MiCultivoController::class, 'reportes'])->name('miCultivo.reportes');
        Route::post('/reportes', [MiCultivoController::class, 'guardarReporte'])->name('miCultivo.reportes.guardar');
        Route::get('/reportes/pdf', [ExportController::class, 'descargarReportePDF'])->name('miCultivo.reportes.pdf');
        Route::get('/calendario', [MiCultivoController::class, 'calendario'])->name('miCultivo.calendario');
    });

    // Rutas para Tu Guia
    Route::prefix('guia')->group(function () {
        Route::get('/variedades', [GuiaController::class, 'variedades'])->name('guia.variedades');
        Route::get('/plagas', [GuiaController::class, 'plagas'])->name('guia.plagas');
        Route::get('/salud', [GuiaController::class, 'salud'])->name('guia.salud');
        Route::get('/practicas', [GuiaController::class, 'practicas'])->name('guia.practicas');
    });

    // Rutas para Asistente
    Route::get('/asistente', [AsistenteController::class, 'index'])->name('asistente');
    Route::post('/asistente', [AsistenteController::class, 'responder'])->name('asistente.responder');

    // Rutas para Control de Riego y sensores
    Route::get('/control', [ControlCultivoController::class, 'index'])->name('control.index');
    Route::post('/control/activar', [ControlCultivoController::class, 'activarRiego'])->name('control.activar');

    // Otras rutas protegidas
    Route::get('/cultivos', [CultivoController::class, 'index'])->name('cultivos');
    Route::get('/sensores', [SensorController::class, 'index'])->name('sensores');
    Route::get('/riego', [RiegoController::class, 'index'])->name('riego');
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion');
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes');
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios');
});

// Redirección para rutas no definidas
Route::fallback(function () {
    return auth()->check() 
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});