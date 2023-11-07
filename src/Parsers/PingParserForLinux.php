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

namespace Acamposm\Ping\Parsers;

final class PingParserForLinux extends PingParser
{
    protected bool $is_unreachable;

    /**
     * PingParserForLinux constructor.
     *
     * @param array $ping
     */
    public function __construct(array $ping)
    {
        parent::__construct($ping);

        $this->is_unreachable = $this->isUnreachable($ping);

        $this->host_status = 'Unreachable';

        $this->setStatistics($ping[count($ping) - 2]);

        if ($this->is_unreachable === false) {
            $this->setRoundTripTime($ping[count($ping) - 1]);
            $this->setSequence();
            $this->setHostStatus();
        }
    }

    private function cleanStatisticsRecord(string $row): array
    {
        $search = explode(
            '|',
            'packets|transmitted|received|+|errors|%|packet|loss|time|ms'
        );

        $row = trim(str_replace($search, '', $row));

        return array_map('trim', explode(', ', $row));
    }

    private function isUnreachable($ping): bool
    {
        $unreachable = false;

        foreach ($ping as $row) {
            if ($unreachable === strpos($row, '100% packet loss')) {
                break;
            }
        }

        return $unreachable !== false;
    }

    /**
     * Get the host status.
     *
     * @return string
     */
    private function getHostStatus(): string
    {
        return ($this->statistics['packet_loss'] < 100) ? 'Ok' : 'Unreachable';
    }

    /**
     * Return an array with the Ping sequence and latency.
     *
     * @return array
     */
    private function getSequence(): array
    {
        $ping = $this->results;

        // Remove unnecessary index
        unset($ping[0]);
        unset($ping[count($ping) - 4]);
        unset($ping[count($ping) - 3]);
        unset($ping[count($ping) - 2]);
        unset($ping[count($ping) - 1]);

        $sequence = [];

        foreach ($ping as $row) {
            if (str_contains($row, 'Unreachable') && !empty($row)) {
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
     * Return an object with Ping Round Trip Time.
     *
     * @param string $row
     *
     * @return array
     */
    private function parseRoundTripTime(string $row): array
    {
        if (!str_contains($row, 'rtt')) {
            return [];
        }

        $row = trim(str_replace(['ms', 'rtt'], '', $row));

        $rtt = explode(' = ', $row);

        $keys = explode('/', $rtt[0]);

        $values = array_map('floatval', explode('/', $rtt[1]));

        return array_combine($keys, $values);
    }

    /**
     * Return an object with Ping Statistics.
     *
     * @param string $row
     *
     * @return array
     */
    private function parseStatistics(string $row): array
    {
        $statistics = $this->cleanStatisticsRecord($row);

        $results = [
            'packets_transmitted' => (int) $statistics[0],
            'packets_received'    => (int) $statistics[1],
            'packets_lost'        => (int) ($statistics[0] - $statistics[1]),
        ];

        if (count($statistics) === 5 && $this->is_unreachable) {
            $results['errors'] = (int) $statistics[2];
        }

        if (count($statistics) === 5) {
            $results['packet_loss'] = (float) $statistics[3];
            $results['time'] = (int) $statistics[4];
        }

        if (count($statistics) === 4) {
            $results['packet_loss'] = (float) $statistics[2];
            $results['time'] = (int) $statistics[3];
        }

        return $results;
    }

    /**
     * Set the host status.
     */
    private function setHostStatus(): void
    {
        $this->host_status = $this->getHostStatus();
    }

    /**
     * Set the Round Trip Time statistics.
     *
     * @param string $rtt
     */
    private function setRoundTripTime(string $rtt): void
    {
        $this->round_trip_time = $this->parseRoundTripTime($rtt);
    }

    /**
     * Set the Ping sequence.
     */
    private function setSequence(): void
    {
        $this->sequence = $this->getSequence();
    }

    /**
     * Set the Statistics.
     *
     * @param string $statistics
     */
    private function setStatistics(string $statistics): void
    {
        $this->statistics = $this->parseStatistics($statistics);
    }

    /**
     * Return the Ping execution result parsed as object.
     *
     * @return object
     */
    public function parse(): object
    {
        $parsed = [
            'host_status' => $this->host_status,
            'raw'         => (object) $this->results,
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
