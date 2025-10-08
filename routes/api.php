<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReporteEquipoController;
use App\Services\WeatherService;
use App\Http\Controllers\Api\ProductoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aquí se registran las rutas públicas para dispositivos (Arduino/ESP32)
| y otras APIs. Estas rutas no requieren autenticación.
|
*/

// Rutas de productos y clima
Route::get('/productos/{id}', [ProductoController::class, 'show']);
Route::get('/clima-tiquipaya', function() {
    return (new WeatherService())->getWeather();
});

// RUTAS PARA ARDUINO (ESP32)

// 1. Arduino envía MAC + humedad
Route::post('/arduino/reporte', [ReporteEquipoController::class, 'registroDesdeArduino']); 

// 2. Obtener datos históricos y último reporte para un equipo (web o Arduino si quieres leer)
Route::get('/reporte-equipo/{equipo_id}/datos', [ReporteEquipoController::class, 'datos']); 

// Ruta opcional protegida para obtener info del usuario (requiere auth con Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
