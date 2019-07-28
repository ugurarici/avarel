<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Schema::defaultStringLength(191);
        // $this->app->bind('App\Helpers\Mahmut', function ($app) {
        //     return new \App\Helpers\Mahmut($app->make('Illuminate\Http\Request'), "falanasdlfkhj");
        // });

        $this->app->singleton('App\Helpers\Mahmut', function ($app) {
            return new \App\Helpers\Mahmut($app->make('Illuminate\Http\Request'), "falanasdlfkhj");
        });

        // $mahmut = new \App\Helpers\Mahmut($this->app->make('Illuminate\Http\Request'), "falanasdlfkhj");
        // $this->app->instance('App\Helpers\Mahmut', $mahmut);
    }
}
