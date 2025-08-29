<?php

namespace App\Providers;

use App\Services\WeatherService;
use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(WeatherService::class, function () {
            return new WeatherService();
        });
    }

    public function boot()
    {
        //
    }
}