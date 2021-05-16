<?php

namespace Acamposm\Ping;

use Acamposm\Ping\Console\InstallPingPackageCommand;
use Illuminate\Support\ServiceProvider;

class PingServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ping');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('ping.php'),
            ], 'config');

            // Registering package commands.
            $this->commands([
                InstallPingPackageCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'ping');

        // Register the main class to use with the facade
        $this->app->singleton('ping', function () {
            return new Ping();
        });
    }
}
