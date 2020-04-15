<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\Ping;
use PHPUnit\Framework\TestCase;

class PingTest extends TestCase
{
    const HOST = '127.0.0.1';

    const COUNT = 10;

    const INTERVAL = 0.5;

    const SIZE = 128;

    const TIMEOUT = 10;

    const TTL = 64;

    /** @test */
    public function isPingClassTest()
    {
        $ping = Ping::Create(Self::HOST);

        $this->assertInstanceOf(Ping::class, $ping);
    }

    /** @test */
    public function canGetPingOptions()
    {
        $options = Ping::Create(Self::HOST);

        $this->assertIsObject($options->GetPingOptions());
    }

    /** @test */
    public function canChangeCountOption()
    {
        $ping = Ping::Create(Self::HOST);

        $options = $ping->GetPingOptions();

        $ping->Count(Self::COUNT);

        $new_options = $ping->GetPingOptions();

        $this->assertNotEquals($options, $new_options, 'Both are equals');
    }

    /** @test */
    public function canChangeIntervalOption()
    {
        $ping = Ping::Create(Self::HOST);

        $options = $ping->GetPingOptions();

        $ping->Interval(Self::INTERVAL);

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
        $ping = Ping::Create(Self::HOST);

        $options = $ping->GetPingOptions();

        $ping->PacketSize(Self::SIZE);

        $new_options = $ping->GetPingOptions();

        $this->assertNotEquals($options, $new_options, 'Both are equals');
    }

    /** @test */
    public function canChangeTimeoutOption()
    {
        $ping = Ping::Create(Self::HOST);

        $options = $ping->GetPingOptions();

        $ping->Timeout(Self::TIMEOUT);

        $new_options = $ping->GetPingOptions();

        $this->assertNotEquals($options, $new_options, 'Both are equals');
    }

    /** @test */
    public function canChangeTTLOption()
    {
        $ping = Ping::Create(Self::HOST);

        $options = $ping->GetPingOptions();

        $ping->TimeToLive(Self::TTL);

        $new_options = $ping->GetPingOptions();

        $this->assertNotEquals($options, $new_options, 'Both are equals');
    }

    /** @test */
    public function canRun()
    {
        $ping = Ping::Create(Self::HOST);

        $this->assertIsObject($ping->Run());
    }
}
