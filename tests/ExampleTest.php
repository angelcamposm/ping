<?php

namespace Acamposm\Ping\Tests;

use Orchestra\Testbench\TestCase;
use Acamposm\Ping\PingServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [PingServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
