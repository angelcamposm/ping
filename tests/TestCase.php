<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\ServiceProviders\PingServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Get application timezone.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return string|null
     */
    protected function getApplicationTimezone($app)
    {
        return 'Europe/Madrid';
    }

    /**
     * Override application aliases.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageAliases($app)
    {
        return [
            'Ping' => 'Acamposm\Ping\Facades\PingFacade',
        ];
    }

    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            PingServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
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
