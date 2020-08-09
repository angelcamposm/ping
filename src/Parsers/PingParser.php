<?php

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
     * Returns the Ping execution result parsed as object
     *
     * @return object
     */
    public function parse(): object
    {
        return (object) $this->raw;
    }
}