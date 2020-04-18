<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingFacade;
use Acamposm\Ping\PingServiceProvider;
use Orchestra\Testbench\TestCase;

class PingTest extends TestCase
{
    const HOST = '127.0.0.1';

    const COUNT = 10;

    const INTERVAL = 0.5;

    const SIZE = 128;

    const TIMEOUT = 10;

    const TTL = 64;

    protected function getPackageProviders($app)
    {
        return ['Acamposm\Ping\PingServiceProvider'];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Ping' => 'Acamposm\Ping\PingFacade'
        ];
    }

    /** @test */
    public function isPingClassTest()
    {
        $ping = Ping::Create(self::HOST);

        $this->assertInstanceOf(Ping::class, $ping);
    }

    /** @test */
    public function canGetPingOptions()
    {
        $options = Ping::Create(self::HOST);

        $this->assertIsObject($options->GetPingOptions());
    }

    /** @test */
    public function canChangeCountOption()
    {
        $ping = Ping::Create(self::HOST);

        $options = $ping->GetPingOptions();

        $ping->Count(self::COUNT);

        $new_options = $ping->GetPingOptions();

        $this->assertNotEquals($options, $new_options, 'Both are equals');
    }

    /** @test */
    public function canChangeIntervalOption()
    {
        $ping = Ping::Create(self::HOST);

        $options = $ping->GetPingOptions();

        $ping->Interval(self::INTERVAL);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {

            // Because in windows cant set interval option
            $this->assertTrue(true);

        } else {

            $new_options = $ping->GetPingOptions();

            $this->assertNotEquals($options, $new_options, 'Both are equals');
        }
    }

    /** @test */
    public function canChangePacketSizeOption()
    {
        $ping = Ping::Create(self::HOST);

        $options = $ping->GetPingOptions();

        $ping->PacketSize(self::SIZE);

        $new_options = $ping->GetPingOptions();

        $this->assertNotEquals($options, $new_options, 'Both are equals');
    }

    /** @test */
    public function canChangeTimeoutOption()
    {
        $ping = Ping::Create(self::HOST);

        $options = $ping->GetPingOptions();

        $ping->Timeout(self::TIMEOUT);

        $new_options = $ping->GetPingOptions();

        $this->assertNotEquals($options, $new_options, 'Both are equals');
    }

    /** @test */
    public function canChangeTTLOption()
    {
        $ping = Ping::Create(self::HOST);

        $options = $ping->GetPingOptions();

        $ping->TimeToLive(self::TTL);

        $new_options = $ping->GetPingOptions();

        $this->assertNotEquals($options, $new_options, 'Both are equals');
    }

    /** @test
     *
     * @throws \Exception
     */
    public function canRun()
    {
        $ping = Ping::Create(self::HOST);

        $this->assertIsObject($ping->Run());
    }
}
