<?php

namespace Eastwest\FBar;

use Eastwest\FBar\Commands\PushCommand;
use Illuminate\Support\ServiceProvider;

class FBarServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-fbar.php' => config_path('laravel-fbar.php'),
        ], 'config');
    }
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole() == false) {
            return;   
        }

        $this->app->singleton(FBarServiceProvider::class, function () {
            return new FBarServiceProvider();
        });

        $this->app->alias(FBarServiceProvider::class, 'fbar');

        $this->commands([
            PushCommand::class
        ]);
    }
}