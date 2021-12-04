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

final class PingParserForWindows extends PingParser implements PingParserInterface
{
    private bool $unreachable;

    /**
     * PingParserForWindows constructor.
     *
     * @param array $ping
     */
    public function __construct(array $ping)
    {
        parent::__construct($ping);

        $this->unreachable = $this->isUnreachable($ping);

        if ($this->unreachable) {
            $this->setStatistics($ping[count($ping) - 2]);
        } else {
            $this->setRoundTripTime($ping[count($ping) - 1]);
            $this->setSequence();
            $this->setStatistics($ping[count($ping) - 4]);
        }

        $this->setHostStatus();
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
        $ping = $this->raw;

        $items_count = count($ping);

        // First remove items from final of the array
        unset($ping[$items_count - 6]);
        unset($ping[$items_count - 5]);
        unset($ping[$items_count - 4]);
        unset($ping[$items_count - 3]);
        unset($ping[$items_count - 2]);
        unset($ping[$items_count - 1]);

        // Then remove first items
        unset($ping[1]);
        unset($ping[0]);

        $key = 0;

        $sequence = [];

        foreach ($ping as $row) {
            $sequence[$key] = $row;

            $key++;
        }

        return $sequence;
    }

    /**
     * Check if the last element of the array has 100% value string.
     *
     * @param array $ping
     *
     * @return bool
     */
    private function isUnreachable(array $ping): bool
    {
        $needles = 'perdidos|lost';

        $result = $ping[count($ping) - 1];

        $unreachable = false;

        foreach (explode('|', $needles) as $needle) {
            $search = strpos($result, '100% '.$needle);

            if ($search !== false) {
                $unreachable = true;
                break;
            }
        }

        return $unreachable;
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
        $rtt = explode(',', str_replace('ms', '', $row));

        $min = (float) explode(' = ', $rtt[0])[1] / 1000;
        $max = (float) explode(' = ', $rtt[1])[1] / 1000;
        $avg = (float) explode(' = ', $rtt[2])[1] / 1000;

        return [
            'avg' => $avg,
            'min' => $min,
            'max' => $max,
        ];
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
        $ping_statistics = explode(', ', explode(':', $row)[1]);

        $transmitted = (int) explode(' = ', $ping_statistics[0])[1];

        $received = (int) explode(' = ', $ping_statistics[1])[1];

        $lost = (int) explode(' = ', $ping_statistics[2])[1];

        return [
            'packets_transmitted' => $transmitted,
            'packets_received'    => $received,
            'packets_lost'        => $lost,
            'packet_loss'         => (int) (100 - (($received * 100) / $transmitted)),
        ];
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
            'raw'         => $this->raw,
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
