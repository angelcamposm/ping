<?php

namespace Acamposm\Ping;

use \stdClass;

class PingParserForLinux extends PingParser
{
    public function __construct(array $ping)
    {
        if (empty($ping) === false) {
            $this->raw = $ping;
            $this->round_trip_time = $this->GetRoundTripTimeStatistics($ping);
            $this->sequence = $this->GetSequence($ping);
            $this->statistics = $this->GetPingStatistics($ping);
            //
            $this->latency = $this->GetLatency();
            $this->result = $this->GetResult();
        }

        return $this;
    }

    /**
     * Return an object with the PING statistics.
     *
     * @param  array  $ping
     * @return  stdClass
     */
    private function GetPingStatistics(array $ping): stdClass
    {
        $lines = count($ping);

        /**
         * Text to be removed from the strings
         * @var array $search
         */
        $search = [
            'packets transmitted',
            'received',
            'packet loss',
            'time',
            '%',
            'ms',
        ];

        $statistics = explode(', ', str_replace($search, '', $ping[$lines - 2]));

        $transmitted = (int) trim($statistics[0]);

        $received = (int) trim($statistics[1]);

        $lost = $transmitted - $received;

        $packet_loss = $statistics[2];

        return (object) [
            'packets_transmitted' => $transmitted,
            'packets_received' => $received,
            'packets_lost' => $lost,
            'packet_loss' => (float) $packet_loss,
            'time' => (int) $statistics[3],
        ];
    }

    /**
     * Returns an object with Round Trip Time Statistics.
     *
     * @param  array  $ping
     * @return  stdClass
     */
    private function GetRoundTripTimeStatistics(array $ping): stdClass
    {
        $lines = count($ping);

        $search = ['rtt', 'ms'];

        $result = trim(str_replace($search, '', $ping[$lines - 1]));

        $rtt = explode(' = ', $result);

        $keys = explode('/', $rtt[0]);

        $values = array_map('floatval', explode('/', $rtt[1]));

        return (object) array_combine($keys, $values);
    }

    /**
     * Returns an array with de packet sequence and his latency.
     *
     * @param  array  $ping
     * @return  array
     */
    private function GetSequence(array $ping): array
    {
        $items_count = count($ping);

        // Remove unnecessary index
        unset($ping[0]);
        unset($ping[$items_count - 4]);
        unset($ping[$items_count - 3]);
        unset($ping[$items_count - 2]);
        unset($ping[$items_count - 1]);

        $sequence = [];

        foreach ($ping as $row) {
            $data = explode(': ', str_replace(' ms', '', $row));
            $items = explode(' ', $data[1]);

            $key = (int) explode('=', $items[0])[1];
            $value = (float) explode('=', $items[2])[1];

            $sequence[$key] = $value;
        }

        return $sequence;
    }
}
