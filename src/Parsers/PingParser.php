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
 * @version  2.1.2
 */

namespace Acamposm\Ping\Parsers;

use Acamposm\Ping\Interfaces\PingParserInterface;

class PingParser implements PingParserInterface
{
    protected array $raw = [];
    protected string $host_status = '';
    protected array $sequence = [];
    protected array $statistics = [];
    protected array $round_trip_time = [];

    /**
     * PingParser constructor.
     *
     * @param array $ping
     */
    public function __construct(array $ping)
    {
        $this->raw = $ping;
    }

    /**
     * Returns the Ping execution result parsed as object.
     *
     * @return object
     */
    public function parse(): object
    {
        return (object) $this->raw;
    }
}
