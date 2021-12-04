<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\Exceptions\MaxValueException;
use Acamposm\Ping\Exceptions\NegativeValueException;
use Acamposm\Ping\PingCommandBuilder;

class PingCommandBuilderTest extends TestCase
{
    public const HOST_IP_ADDRESS = '127.0.0.1';
    public const HOST_LINK_LOCAL = 'fe80::6c42:407d:af01:9567';
    public const HOST_URL = 'google.com';

    /**
     * @test
     *
     * @throws \Acamposm\Ping\Exceptions\UnknownOSException
     */
    public function can_get_IPv4_command()
    {
        $command = (new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS))->get();

        $this->assertStringContainsString(PingCommandBuilderTest::HOST_IP_ADDRESS, $command);
    }

    /**
     * @test
     *
     * @throws \Acamposm\Ping\Exceptions\UnknownOSException
     */
    public function can_get_IPv6_command()
    {
        $command = (new PingCommandBuilder(PingCommandBuilderTest::HOST_LINK_LOCAL))->get();

        $this->assertStringContainsString(PingCommandBuilderTest::HOST_LINK_LOCAL, $command);
    }

    /**
     * @test
     *
     * @throws \Acamposm\Ping\Exceptions\UnknownOSException
     */
    public function can_get_URL_command()
    {
        $command = (new PingCommandBuilder(PingCommandBuilderTest::HOST_URL))->get();

        $this->assertStringContainsString(PingCommandBuilderTest::HOST_URL, $command);
    }

    /**
     * @test
     *
     * @throws NegativeValueException
     */
    public function can_set_count()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        $options = $command->getOptions();

        $command->count(10);

        $this->assertNotEquals($command->getOptions(), $options);
    }

    /**
     * @test
     */
    public function can_not_set_a_negative_value_to_count()
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
    public function can_set_interval()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        $options = $command->getOptions();

        $command->interval(2);

        $this->assertNotEquals($command->getOptions(), $options);
    }

    /**
     * @test
     */
    public function can_set_packet_size()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        $options = $command->getOptions();

        $command->packetSize(128);

        $this->assertNotEquals($command->getOptions(), $options);
    }

    /**
     * @test
     */
    public function can_set_timeout()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        $options = $command->getOptions();

        $command->timeout(10);

        $this->assertNotEquals($command->getOptions(), $options);
    }

    /**
     * @test
     *
     * @throws MaxValueException
     */
    public function can_set_ttl()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        $options = $command->getOptions();

        $command->ttl(128);

        $this->assertNotEquals($command->getOptions(), $options);
    }

    /**
     * @test
     */
    public function can_not_set_ttl_value_greater_than()
    {
        $command = new PingCommandBuilder(PingCommandBuilderTest::HOST_IP_ADDRESS);

        try {
            $command->ttl(300);
        } catch (MaxValueException $e) {
            $this->assertInstanceOf(MaxValueException::class, $e);
        }
    }
}
