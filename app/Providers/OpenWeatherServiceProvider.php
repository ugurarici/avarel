<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Weather;
use View;
use Cache;

class OpenWeatherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Cmfcmf\OpenWeatherMap', function($app){
            return new Weather(
                config('services.openweather.key'), 
                $app->make('Http\Adapter\Guzzle6\Client'), 
                $app->make('Http\Factory\Guzzle\RequestFactory')
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Weather $weatherService)
    {
        $weather = Cache::remember('weather', 300, function () use ($weatherService) {
            return $weatherService->getWeather('Bolu', 'metric', 'tr');
        });
        View::share('weather', $weather);
    }
}
