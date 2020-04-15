<?php

namespace Acamposm\Ping;

use \stdClass;

abstract class PingParser
{
    /**
     * Latency.
     *
     * @var  float
     */
    protected $latency = 0;

    /**
     * Round Trip Time statistics.
     *
     * @var  array
     */
    protected $round_trip_time = [];

  	/**
     * Result of the PING
     *
     * @var  string
     */
  	protected $result = '';

    /**
     * ICMP Sequence.
     *
     * @var  array
     */
    protected $sequence = [];

    /**
     * PING Statistics.
     *
     * @var  array
     */
    protected $statistics = [];

    /**
     * Output to be parsed from EXEC PING command.
     *
     * @var  array
     */
    protected $raw = [];

    public function __construct(array $ping)
    {
      	$this->raw = $ping;

        return $this;
    }

    public static function Create(array $ping)
    {
        return new static($ping);
    }

    /**
     * Returns the latency for the connection
     * Requires $this->round_trip_time values.
     *
     * @return  float
     */
    protected function GetLatency(): float
    {
        if (empty($this->round_trip_time)) {
            return 0;
        }

        return $this->round_trip_time->avg;
    }

    /**
     * Returns the result of the Ping
     * Requires $this->statistics values.
     *
     *  @return  string
     */
    protected function GetResult(): string
    {
        if (empty($this->statistics)) {
            return 'Unknown';
        }

        return $this->statistics->packet_loss < 100 ? 'Ok' : 'Unreachable';
    }

    /**
     * Return a parsed object.
     *
     * @return  stdClass
     */
    public function Parse(): stdClass
    {
        return (object) [
            'latency' => $this->latency,
            'result' => $this->result,
            'round_trip_time' => $this->round_trip_time,
            'sequence' => $this->sequence,
            'statistics' => $this->statistics,
            'raw' => $this->raw,
        ];
    }
}
