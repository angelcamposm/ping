<?php

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
            '--provider' => "Acamposm\Ping\PingServiceProvider",
            '--tag' => "config"
        ]);

        $this->info('Installed PingPackage');
    }
}
