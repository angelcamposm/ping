<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\PingServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app): array
    {
        return [
            PingServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('ping', [
            'count'       => 5,
            'interval'    => 1,
            'packet_size' => 64,
            'timeout'     => 8,
            'ttl'         => 60,
        ]);
    }
}
