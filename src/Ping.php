<?php

/**
 * Ping for Laravel.
 *
 * This class makes Ping request to a host.
 *
 * Ping uses the ICMP protocol's mandatory ECHO_REQUEST datagram to elicit an ICMP ECHO_RESPONSE from a host or gateway.
 *
 * @author  Angel Campos <angel.campos.m@outlook.com>
 * @requires PHP 8.0
 *
 * @version  2.1.2
 */

namespace Acamposm\Ping;

use Acamposm\Ping\Exceptions\UnknownOSException;
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
     *
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
     *
     * @throws UnknownOSException
     *
     * @return object
     */
    protected function parse(array $ping): object
    {
        if (System::isLinux()) {
            return (new PingParserForLinux($ping))->parse();
        }

        if (System::isWindows()) {
            return (new PingParserForWindows($ping))->parse();
        }

        throw new UnknownOSException();
    }

    /**
     * Remove binary casting from the beginning of the strings.
     *
     * @param array $ping
     *
     * @return array
     */
    private function cleanBinaryString(array $ping): array
    {
        $cleaned = [];

        foreach ($ping as $row) {
            $cleaned[] = preg_replace('/[[:^print:]]/', '', $row);
        }

        return $cleaned;
    }

    /**
     * @throws Exception
     *
     * @return object
     */
    public function run(): object
    {
        $ping = $this->executePing();

        // Return the result if lines count are less than three.
        if (count($ping) < 3) {
            return (object) $ping;
        }

        $ping_object = ($this->parse($ping));

        $ping_object->options = $this->command->getOptions();
        $ping_object->time = $this->timer->getResults();

        return $ping_object;
    }

    /**
     * Return the result of the execution of ping command.
     *
     * @throws Exception
     *
     * @return array
     */
    private function executePing(): array
    {
        exec($this->command->get(), $exec_result);

        if (!is_array($exec_result)) {
            throw new Exception('Ping failed');
        }

        return $this->cleanBinaryString($exec_result);
    }
}
