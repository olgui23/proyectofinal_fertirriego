<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
use App\Services\WeatherService;
use App\Http\Controllers\Api\ProductoController;    
Route::get('/productos/{id}', [ProductoController::class, 'show']);

Route::get('/clima-tiquipaya', function() {
    return (new WeatherService())->getWeather();
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
use App\Http\Controllers\ReporteEquipoController;

Route::post('/reporte-equipo', [ReporteEquipoController::class, 'store']); // desde ESP32
Route::get('/reporte-equipo/{equipo_id}/datos', [ReporteEquipoController::class, 'datos']); // para gráfica






