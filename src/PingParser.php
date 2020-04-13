<?php

namespace Acamposm\Ping;

class PingParser
{
    /**
     * Determine if is a Windows based Operating System
     * 
     * @var boolean
     */
    protected $is_windows_os = false;

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

    public function __construct($ping)
    {
        // Determine if is a Windows based Operating System
        if (in_array(PHP_OS, array('WIN32', 'WINNT', 'Windows'))) {
            $this->is_windows_os = true;
        }

        $this->round_trip_time = $this->GetRoundTripTimeStatistics($ping);
        // requires $this->round_trip_time
        $this->latency = $this->GetLatency();
        $this->raw = $ping;
        $this->sequence = $this->GetSequence($ping);
        $this->statistics = $this->GetPingStatistics($ping);

        return $this;
    }

    public static function Create($ping)
    {
        return new static($ping);
    }

    /**
     * Returns the latency for the connection
     * Requires $this->round_trip_time values.
     *
     * @return  float
     */
    private function GetLatency(): float
    {
        if (empty($this->round_trip_time)) {
            return 0;
        }

        return $this->round_trip_time['avg'];
    }

    /**
     * Return an array with the PING statistics.
     *
     * @param  array  $ping
     * @return  array
     */
    private function GetPingStatistics($ping): array
    {
        $lines = count($ping);

        if ($this->is_windows_os) {

            $ping_statistics = explode(', ', explode(':', $ping[$lines - 4])[1]);

            $transmitted = (int) explode(' = ', $ping_statistics[0])[1];

            $received = (int) explode(' = ', $ping_statistics[1])[1];

            $lost = (int) explode(' = ', $ping_statistics[2])[1];

            return [
                'packets_transmitted' => $transmitted,
                'packets_received' => $received,
                'packet_loss' => $lost,
                'packet_loss' => (int) (100 - (($received * 100) / $transmitted))
            ];
        }

        $search = [
            'packets transmitted',
            'received',
            'packet loss',
            'time',
            '%',
            'ms',
        ];

        $statistics = explode(', ', str_replace($search, '', $ping[$lines - 2]));

        return [
            'packets_transmitted' => (int) $statistics[0],
            'packets_received' => (int) $statistics[1],
            'packet_loss' => (float) $statistics[2],
            'time' => (int) $statistics[3],
        ];
    }

    /**
     * Returns an array with Round Trip Time Statistics.
     *
     * @param  array  $ping
     * @return  array
     */
    private function GetRoundTripTimeStatistics($ping): array
    {
        $lines = count($ping);

        if ($this->is_windows_os) {
            
            $rtt = explode(',', str_replace('ms', '', $ping[$lines - 1]));

            $min = (float) explode(' = ', $rtt[0])[1] / 1000;
            $max = (float) explode(' = ', $rtt[1])[1] / 1000;
            $avg = (float) explode(' = ', $rtt[2])[1] / 1000;

            return [
                'avg' => $avg,
                'min' => $min,
                'max' => $max,
            ];
        }

        $search = ['rtt', 'ms'];

        $result = trim(str_replace($search, '', $ping[$lines - 1]));

        if (strlen($result) === 0) {
            return [];
        }

        $rtt = explode(' = ', $result);

        $keys = explode('/', $rtt[0]);

        $values = array_map('floatval', explode('/', $rtt[1]));

        return array_combine($keys, $values);
    }

    /**
     * Returns an array with de packet sequence and his latency.
     *
     * @return  array
     */
    private function GetSequence($ping): array
    {
        $items_count = count($ping);

        if ($this->is_windows_os) {

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
          
            foreach ($ping as $row) {
                if (strpos(':', $row) === false) {
                    $sequence[$key] = $row;
                } else {
                    $sequence[$key] = explode(': ', $row)[1];
                }

                $key++;
            }

            return $sequence;
        }

        // Remove unnecesary index
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

    public function Parse()
    {
        return (object) [
            'latency' => $this->latency,
            'round_trip_time' => $this->round_trip_time,
            'sequence' => $this->sequence,
            'statistics' => $this->statistics,
            'raw' => $this->raw,
        ];
    }
}
