<?php
namespace App\Services;
use Illuminate\Support\Facades\Http;

class WeatherService {
    public function getWeather() {
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'lat' => -17.3333,  // Latitud de Tiquipaya
            'lon' => -66.2167,  // Longitud de Tiquipaya
            'appid' => env('OPENWEATHER_API_KEY'),
            'units' => 'metric',
            'lang' => 'es'
        ]);

        return $response->json();
    }
}