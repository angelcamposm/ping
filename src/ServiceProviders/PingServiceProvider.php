<?php

/**
 * Ping for Laravel.
 *
 * This class makes Ping request to a host.
 *
 * Ping uses the ICMP protocol's mandatory ECHO_REQUEST datagram to elicit an ICMP ECHO_RESPONSE from a host or gateway.
 *
 * @author  Angel Campos <angel.campos.m@outlook.com>
 * @requires PHP 8.0
 * @version  2.1.2
 */

namespace Acamposm\Ping\ServiceProviders;

use Acamposm\Ping\Console\InstallPingPackageCommand;
use Acamposm\Ping\Ping;
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
                __DIR__ . '/../../config/config.php' => config_path('ping.php'),
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
        $this->mergeConfigFrom(__DIR__ . '/../../config/config.php', 'ping');

        // Register the main class to use with the facade
        $this->app->singleton('ping', function () {
            return new Ping();
        });
    }
}
