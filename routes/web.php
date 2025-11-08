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
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PerfilController;

use App\Http\Controllers\ReporteEquipoController;

// Panel de control
Route::get('/reporte-equipos', [ReporteEquipoController::class, 'index'])->name('reporte_equipos.index');

// Obtener datos de un equipo (AJAX y Arduino)
Route::get('/reporte-equipos/{equipo}/datos', [ReporteEquipoController::class, 'datos']);

// Ejecutar acción de equipo (AJAX y Arduino)
Route::post('/reporte-equipos/{equipo}/accion', [ReporteEquipoController::class, 'accion']);

//aqui es lo otro 
Route::resource('equipos', EquipoController::class);
//Rutas reportes administrador

Route::middleware(['auth', 'rol:administrador'])->group(function () {
    Route::get('/reportes', [ReporteController::class, 'index'])->name('reportes.index');
    Route::get('/reportes/agricultores', [ReporteController::class, 'agricultores'])->name('reportes.agricultores');
    Route::get('/reportes/equipos', [ReporteController::class, 'equipos'])->name('reportes.equipos');
    Route::get('/reportes/ventas', [ReporteController::class, 'ventas'])->name('reportes.ventas');
});

// RUTAS PARA VISTA DE REPORTES DE RIEGO
Route::get('/cultivo/reporte', [RiegoController::class, 'reporte'])->name('cultivo.reporte');
Route::get('/cultivo/reporte/pdf', [RiegoController::class, 'reportePDF'])->name('cultivo.reporte.pdf');

// RUTAS PARA VISTA DE REPORTES DE RIEGO (REPORTE2)
Route::get('/cultivo/reporte2', [RiegoController::class, 'reporte2'])->name('cultivo.reporte2');
Route::get('/cultivo/reporte2/pdf', [RiegoController::class, 'reportePDF2'])->name('cultivo.reporte2.pdf');

// CRUD de agricultores solo para admin
Route::prefix('administrador')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'agricultores'])->name('administrador.index');
    Route::get('/create', [AdminController::class, 'crearAgricultor'])->name('administrador.create');
    Route::post('/', [AdminController::class, 'guardarAgricultor'])->name('administrador.store');
    Route::get('/{id}/edit', [AdminController::class, 'editarAgricultor'])->name('administrador.edit');
    Route::put('/{id}', [AdminController::class, 'actualizarAgricultor'])->name('administrador.update');
    Route::delete('/{id}', [AdminController::class, 'eliminarAgricultor'])->name('administrador.destroy');
});

// Perfil (editable)
   // 🔒 Perfil (solo usuarios autenticados)
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');
});


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
    // RUTAS SUGERIDAS EN `web.php`
        Route::get('/productos/crear', [ProductoController::class, 'crear'])->name('productos.crear');
        Route::get('/productos/editar/{id}', [ProductoController::class, 'editar'])->name('productos.editar');
        Route::post('/productos', [ProductoController::class, 'guardar'])->name('productos.guardar');
        Route::put('/productos/{id}', [ProductoController::class, 'actualizar'])->name('productos.update');
        Route::delete('/productos/{id}', [ProductoController::class, 'eliminar'])->name('productos.eliminar');

    // Rutas para VENTAS
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::post('/ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::post('/ventas/{id}/aprobar', [VentaController::class, 'aprobar'])->name('ventas.aprobar');
    Route::post('/ventas/{id}/rechazar', [VentaController::class, 'rechazar'])->name('ventas.rechazar');
    Route::get('/ventas/{id}/pdf', [App\Http\Controllers\VentaController::class, 'pdf'])->name('ventas.pdf');
    Route::get('/ventas/reporte', [VentaController::class, 'reporte'])->name('ventas.reporte');


Route::middleware(['auth', 'rol:agricultor'])->group(function () {
    Route::get('/mis-productos', [ProductoController::class, 'misProductos'])->name('productos.agricultor');
    Route::get('/productos/agricultor', [ProductoController::class, 'agricultor'])->name('productos.agricultor');

    Route::post('/productos/{id}/toggle-disponible', [ProductoController::class, 'toggleDisponible'])->name('productos.toggleDisponible');
});


    
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
Route::get('/api/user-roles', [App\Http\Controllers\AdminController::class, 'userRolesData']);
 // RUTAS PARA PDF AGRICULTORES
 Route::get('administrador/agricultores/pdf', [App\Http\Controllers\AdminController::class, 'exportPdf'])->name('administrador.agricultores.pdf');
// Mostrar vista con PDF embebido
Route::get('/administrador/agricultores/pdf-view', [AdminController::class, 'viewPdf'])->name('administrador.agricultores.pdf-view');

// Descargar PDF directamente
Route::get('/administrador/agricultores/pdf-download', [AdminController::class, 'downloadPdf'])->name('administrador.agricultores.pdf-download');

// DESCARGAR PDF DE EQUIPOS
Route::get('/equipos/pdf-view', [EquipoController::class, 'viewPdf'])->name('equipos.pdf-view');
Route::get('/equipos/pdf-download', [EquipoController::class, 'downloadPdf'])->name('equipos.pdf-download');

// 🛍️ Ver mis compras (solo comprador)
Route::middleware(['auth', 'rol:comprador'])->group(function () {
    Route::get('/mis-compras', [VentaController::class, 'misCompras'])->name('ventas.miscompras');
    // Mostrar detalle de una compra específica
Route::get('/ventas/{id}', [VentaController::class, 'show'])->name('ventas.show');

});
