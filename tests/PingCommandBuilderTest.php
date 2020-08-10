<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\Exceptions\MaxValueException;
use Acamposm\Ping\Exceptions\NegativeValueException;
use Acamposm\Ping\PingCommandBuilder;

class PingCommandBuilderTest extends TestCase
{
    const HOST_IP_ADDRESS = '127.0.0.1';
    const HOST_LINK_LOCAL = 'fe80::6c42:407d:af01:9567';
    const HOST_URL = 'google.com';

    /**
     * @test
     */
    public function canGetIPv4Command()
    {
        $command = (new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS))->get();

        $this->assertStringContainsString(PingCommandBuilderTest::HOST_IP_ADDRESS, $command);
    }

    /**
     * @test
     */
    public function canGetIPv6Command()
    {
        $command = (new PingCommandBuilder(PingCommandBuilderTest::HOST_LINK_LOCAL))->get();

        $this->assertStringContainsString(PingCommandBuilderTest::HOST_LINK_LOCAL, $command);
    }

    /**
     * @test
     */
    public function canGetUrlCommand()
    {
        $command = (new PingCommandBuilder(PingCommandBuilderTest::HOST_URL))->get();

        $this->assertStringContainsString(PingCommandBuilderTest::HOST_URL, $command);
    }

    /**
     * @test
     */
    public function canChangeCount()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        $options = $command->getOptions();

        $command->count(10);

        $this->assertNotEquals($command->getOptions(), $options);
    }

    /**
     * @test
     */
    public function cantSetNegativeValueToCount()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        try {
            $command->count(-4);
        } catch (NegativeValueException $e) {
            $this->assertInstanceOf(NegativeValueException::class, $e);
        }
    }

    /**
     * @test
     */
    public function canChangeInterval()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        $options = $command->getOptions();

        $command->interval(2);

        $this->assertNotEquals($command->getOptions(), $options);
    }

    /**
     * @test
     */
    public function canChangePacketSize()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        $options = $command->getOptions();

        $command->packetSize(128);

        $this->assertNotEquals($command->getOptions(), $options);
    }

    /**
     * @test
     */
    public function canChangeTimeout()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        $options = $command->getOptions();

        $command->timeout(10);

        $this->assertNotEquals($command->getOptions(), $options);
    }

    /**
     * @test
     */
    public function canChangeTtl()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        $options = $command->getOptions();

        $command->ttl(128);

        $this->assertNotEquals($command->getOptions(), $options);
    }

    /**
     * @test
     */
    public function cantSetMaxValue()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        try {
            $command->ttl(300);
        } catch (MaxValueException $e) {
            $this->assertInstanceOf(MaxValueException::class, $e);
        }
    }
}
