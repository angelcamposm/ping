<?php

namespace Acamposm\Ping\Tests\Feature;

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommandBuilder;
use Acamposm\Ping\Tests\TestCase;
use Exception;

class PingTest extends TestCase
{
    public const LOCALHOST = '127.0.0.1';

    /**
     * @test
     *
     * @return PingCommandBuilder
     */
    public function it_can_create_a_builder(): PingCommandBuilder
    {
        $command = (new PingCommandBuilder(self::LOCALHOST));

        $this->assertInstanceOf(PingCommandBuilder::class, $command);

        return $command;
    }

    /**
     * @test
     *
     * @depends it_can_create_a_builder
     *
     * @param PingCommandBuilder $command
     *
     * @return object
     *
     * @throws Exception
     */
    public function it_can_make_ping(PingCommandBuilder $command): object
    {
        $ping = (new Ping($command))->run();

        $this->assertIsObject($ping);

        return $ping;
    }

    /**
     * @test
     *
     * @depends it_can_make_ping
     *
     * @param object $ping
     *
     * @return void
     */
    public function it_can_read_host_status_from_result(object $ping)
    {
        $this->assertObjectHasProperty('host_status', $ping);
    }

    /**
     * @test
     *
     * @depends it_can_make_ping
     *
     * @param object $ping
     *
     * @return void
     */
    public function it_can_read_raw_from_result(object $ping)
    {
        $this->assertObjectHasProperty('raw', $ping);

        $this->assertIsObject($ping->raw);
    }

    /**
     * @test
     *
     * @depends it_can_make_ping
     *
     * @param object $ping
     *
     * @return void
     */
    public function it_can_read_options_from_result(object $ping)
    {
        $this->assertObjectHasProperty('raw', $ping);

        $this->assertIsObject($ping->options);
    }
}
