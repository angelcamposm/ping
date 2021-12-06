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
     */
    public function it_can_create_an_ipv4_instance(): PingCommandBuilder
    {
        $instance = new PingCommandBuilder(self::HOST_IP_ADDRESS);

        $this->assertInstanceOf(PingCommandBuilder::class, $instance);

        return $instance;
    }

    /**
     * @test
     * @depends it_can_create_an_ipv4_instance
     * @throws \Acamposm\Ping\Exceptions\UnknownOSException
     */
    public function can_get_IPv4_command(PingCommandBuilder $command)
    {
        $this->assertStringContainsString(self::HOST_IP_ADDRESS, $command->get());
    }

    /**
     * @test
     *
     * @throws \Acamposm\Ping\Exceptions\UnknownOSException
     */
    public function can_get_IPv6_command()
    {
        $command = new PingCommandBuilder(self::HOST_LINK_LOCAL);

        $this->assertStringContainsString(self::HOST_LINK_LOCAL, $command->get());
    }

    /**
     * @test
     *
     * @throws \Acamposm\Ping\Exceptions\UnknownOSException
     */
    public function can_get_URL_command()
    {
        $command = new PingCommandBuilder(self::HOST_URL);

        $this->assertStringContainsString(self::HOST_URL, $command->get());
    }

    /**
     * @test
     * @depends it_can_create_an_ipv4_instance
     * @throws NegativeValueException
     */
    public function can_set_count(PingCommandBuilder $command)
    {
        $this->assertNotEquals(
            $command->getOptions(),
            $command->count(10)->getOptions(),
        );
    }

    /**
     * @test
     * @depends it_can_create_an_ipv4_instance
     */
    public function can_not_set_a_negative_value_to_count(PingCommandBuilder $command)
    {
        $this->expectException(NegativeValueException::class);

        $command->count(-4);
    }

    /**
     * @test
     * @depends it_can_create_an_ipv4_instance
     */
    public function can_set_interval(PingCommandBuilder $command)
    {
        $this->assertNotEquals(
            $command->getOptions(),
            $command->interval(2)->getOptions(),
        );
    }

    /**
     * @test
     * @depends it_can_create_an_ipv4_instance
     */
    public function can_set_packet_size(PingCommandBuilder $command)
    {
        $this->assertNotEquals(
            $command->getOptions(),
            $command->packetSize(128)->getOptions(),
        );
    }

    /**
     * @test
     * @depends it_can_create_an_ipv4_instance
     */
    public function can_set_timeout(PingCommandBuilder $command)
    {
        $this->assertNotEquals(
            $command->getOptions(),
            $command->timeout(10)->getOptions(),
        );
    }

    /**
     * @test
     * @depends it_can_create_an_ipv4_instance
     * @throws MaxValueException
     */
    public function it_can_set_ttl(PingCommandBuilder $command)
    {
        $this->assertNotEquals(
            $command->getOptions(),
            $command->ttl(128)->getOptions(),
        );
    }

    /**
     * @test
     * @depends it_can_create_an_ipv4_instance
     */
    public function it_can_not_set_ttl_value_greater_than(PingCommandBuilder $command)
    {
        $this->expectException(MaxValueException::class);

        $command->ttl(300);
    }
}
