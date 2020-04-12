<?php

namespace Acamposm\Ping;

/**
 * 
 */
class PingParser
{
	/**
	 * Latency
	 *
	 * @var  float
	 */
	protected $latency = 0;

	/**
	 * Round Trip Time statistics
	 *
	 * @var  array
	 */
	protected $round_trip_time = [];

	/**
	 * ICMP Sequence
	 *
	 * @var  array
	 */
	protected $sequence = [];

	/**
	 * PING Statistics
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

	function __construct($ping)
	{
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
	 * Requires $this->round_trip_time values
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
	 * Return an array with the PING statistics
	 *
	 * @param  array  $ping
	 * @return  array
	 */
  	private function GetPingStatistics($ping): array
    {
      	$lines = count($ping);
      
      	$search = [
        	'packets transmitted',
          	'received',
          	'packet loss',
          	'time',
          	'%',
          	'ms'
        ];
      
      	$statistics = explode(', ',str_replace($search, '', $ping[$lines - 2]));

      	return [
        	'packets_transmitted' => (int) $statistics[0],
          	'packets_received' => (int) $statistics[1],
          	'packet_loss' => (float) $statistics[2],
          	'time' => (int) $statistics[3]
        ];
    }

    /**
     * Returns an array with Round Trip Time Statistics
     *
     * @param  array  $ping
     * @return  array
     */
  	private function GetRoundTripTimeStatistics($ping): array
    {
      	$lines = count($ping);

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
     * Returns an array with de packet sequence and his latency
     *
     * @return  array
     */
    private function GetSequence($ping): array
    {
        $items_count = count($ping);

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

            $key = (integer) explode('=', $items[0])[1];
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
          	'raw' => $this->raw
        ];
    }
}