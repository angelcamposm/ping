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
 *
 * @version  2.1.2
 */

namespace Acamposm\Ping\Console;

use Illuminate\Console\Command;

class InstallPingPackageCommand extends Command
{
    protected $signature = 'ping:install';

    protected $description = 'Install the Ping package';

    public function handle()
    {
        $this->info('Installing PingPackage...');

        $this->info('Publishing configuration...');

        $this->call('vendor:publish', [
            '--provider' => 'Acamposm\Ping\PingServiceProvider',
            '--tag'      => 'config',
        ]);

        $this->info('Installed PingPackage');
    }
}
