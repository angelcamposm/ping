<?php

/**
 * Ping for PHP.
 *
 * This class makes Ping request to a host.
 *
 * Ping uses the ICMP protocol's mandatory ECHO_REQUEST datagram to elicit an ICMP ECHO_RESPONSE from a host or gateway.
 *
 * @version  0.2.0
 * @author  Angel Campos <angel.campos.m@outlook.com>
 */

namespace Acamposm\Ping;

use Acamposm\Ping\Parsers\PingParserForLinux;
use Acamposm\Ping\Parsers\PingParserForWindows;
use Exception;

class Ping
{
    /**
     * @var PingCommandBuilder
     */
    protected PingCommandBuilder $command;

    /**
     * @var Timer
     */
    protected Timer $timer;

    /**
     * Ping constructor.
     * @param PingCommandBuilder $command
     */
    public function __construct(PingCommandBuilder $command)
    {
        $this->command = $command;

        $this->timer = new Timer();
        $this->timer->Start();
    }

    /**
     * Parse the ping result and return an object.
     *
     * @param array $ping
     * @return object
     * @throws Exception
     */
    protected function parse(array $ping): object
    {
        if (System::isLinux()) {
            return (new PingParserForLinux($ping))->parse();
        }

        if (System::isWindows()) {
            return (new PingParserForWindows($ping))->parse();
        }

        throw new Exception("There's no parser for these results");
    }

    /**
     * @return object
     * @throws Exception
     */
    public function run(): object
    {
        exec($this->command->get(), $exec_result);

        if (! is_array($exec_result)) {
            throw new Exception('Ping failed');
        }

        $ping_object = ($this->parse($exec_result));

        $ping_object->options = $this->command->getOptions();
        $ping_object->time = $this->timer->getResults();

        return $ping_object;
    }
}
