<?php

namespace Acamposm\Ping\Parsers;

use Acamposm\Ping\Interfaces\PingParserInterface;

final class PingParserForLinux extends PingParser implements PingParserInterface
{
    /**
     * PingParserForLinux constructor.
     *
     * @param array $ping
     */
    public function __construct(array $ping)
    {
        parent::__construct($ping);

        $this->setRoundTripTime($ping[count($ping) - 1]);
        $this->setSequence();
        $this->setStatistics($ping[count($ping) -2]);
        $this->setHostStatus();
    }

    /**
     * Get the host status
     *
     * @return string
     */
    private function getHostStatus(): string
    {
        return ($this->statistics['packet_loss'] < 100) ? 'Ok' : 'Unreachable';
    }

    /**
     * Return an array with the Ping sequence and latency
     *
     * @return array
     */
    private function getSequence(): array
    {
        $ping = $this->raw;

        // Remove unnecessary index
        unset($ping[0]);
        unset($ping[count($ping) - 4]);
        unset($ping[count($ping) - 3]);
        unset($ping[count($ping) - 2]);
        unset($ping[count($ping) - 1]);

        $sequence = [];

        foreach ($ping as $row) {

            if (strpos('Unreachable', $row) !== false) {

                $data = explode(': ', str_replace(' ms', '', $row));
                $items = explode(' ', $data[1]);

                $key = (int) explode('=', $items[0])[1];
                $value = (float) explode('=', $items[2])[1];

                $sequence[$key] = $value;
            }
        }

        return $sequence;
    }

    /**
     * Return an object with Ping Round Trip Time
     *
     * @param string $row
     * @return array
     */
    private function parseRoundTripTime(string $row): array
    {
        if (strpos('rtt', $row) === false) {
            return [];
        }

        $row = trim(str_replace(['ms', 'rtt'], null, $row));

        $rtt = explode(' = ', $row);

        $keys = explode('/', $rtt[0]);

        $values = array_map('floatval', explode('/', $rtt[1]));

        return array_combine($keys, $values);
    }

    /**
     * Return an object with Ping Statistics
     *
     * @param string $row
     * @return array
     */
    private function parseStatistics(string $row): array
    {
        $search = explode('|' ,'packets|transmitted|received|+|errors|%|packet|loss|time|ms');

        $row = trim(str_replace($search, null, $row));

        $statistics = array_map('trim', explode(', ', $row));

        if (count($statistics) === 5) {

            return [
                'packets_transmitted' => (int) $statistics[0],
                'packets_received' => (int) $statistics[1],
                'packets_lost' => (int) ($statistics[0] - $statistics[1]),
                'packet_loss' => (float) $statistics[3],
                'time' => (int) $statistics[4],
            ];
        }

        return [
            'packets_transmitted' => (int) $statistics[0],
            'packets_received' => (int) $statistics[1],
            'packets_lost' => (int) ($statistics[0] - $statistics[1]),
            'packet_loss' => (float) $statistics[2],
            'time' => (int) $statistics[3],
        ];
    }

    /**
     * Set the host status
     */
    private function setHostStatus(): void
    {
        $this->host_status = $this->getHostStatus();
    }

    /**
     * Set the Round Trip Time statistics
     *
     * @param string $rtt
     */
    private function setRoundTripTime(string $rtt): void
    {
        $this->round_trip_time = $this->parseRoundTripTime($rtt);
    }

    /**
     * Set the Ping sequence
     */
    private function setSequence(): void
    {
        $this->sequence = $this->getSequence();
    }

    /**
     * Set the Statistics
     *
     * @param string $statistics
     */
    private function setStatistics(string $statistics): void
    {
        $this->statistics = $this->parseStatistics($statistics);
    }

    /**
     * Return the Ping execution result parsed as object
     *
     * @return object
     */
    public function parse(): object
    {
        $parsed = [
            'host_status' => $this->host_status,
            'raw' => (object) $this->raw,
        ];

        if (count($this->round_trip_time) > 0) {
            $parsed['latency'] = $this->round_trip_time['avg'];
            $parsed['rtt'] = (object) $this->round_trip_time;
        }

        if (count($this->sequence) > 0) {
            $parsed['sequence'] = (object) $this->sequence;
        }

        if (count($this->statistics) > 0) {
            $parsed['statistics'] = (object) $this->statistics;
        }

        return (object) $parsed;
    }
}