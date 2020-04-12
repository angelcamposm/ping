<?php

/**
 * Ping for PHP.
 *
 * This class makes Ping request to a host using Ping command from IPutils linux package
 *
 * Ping uses the ICMP protocol's mandatory ECHO_REQUEST datagram to elicit an ICMP ECHO_RESPONSE from a host or gateway.
 * 
 * @version  1.0.0
 * @author  Angel Campos <angel.campos.m@outlook.com>
 */

namespace Acamposm\Ping;

use Acamposm\Ping\PingCommand;
use Acamposm\Ping\PingParser;
use Acamposm\Ping\Timer;

class Ping
{
    /**
     * The IP address of the host
     *
     * @var  string
     */
    private $host;

    /**
     * Stop after sending count ECHO_REQUEST packets.
     *
     * @var  integer
     */
    private $count = 4;

    /**
     * Wait interval seconds between sending each packet. The default is to 
     * wait for one second between each packet normally, or not to wait in 
     * flood mode. 
     * Only super-user may set interval to values less than 0.2 seconds.
     *
     * @var  integer
     */
    private $interval = 1;

    /**
     * Specifies the number of data bytes to be sent. 
     * The default is 56, which translates into 64 ICMP data bytes when 
     * combined with the 8 bytes of ICMP header data.
     *
     * @var  integer
     */
    private $packet_size = 64;

    /**
     * Time to wait for a response, in seconds. The option affects only 
     * timeout in absence of any responses, otherwise ping waits for two RTTs.
     *
     * @var  integer
     */
    private $timeout = 5;

    /**
     * The TTL value of an IP packet represents the maximum number of IP 
     * routers that the packet can go through before being thrown away.  
     * In current practice you can expect each router in the Internet to 
     * decrement the TTL field by exactly one.
     *
     * @var  integer
     */
    private $time_to_live = 128;

    /**
     * The Exit from the exec command
     *
     * @var  string[]
     */
    private $exec_result;

    /**
     * An object to allow us to control the total execution time
     *
     * @var  stdClass
     */
    private $timer;

    function __construct($host)
    {
    	$this->host = $host;
    	$this->timer = new Timer();
    }

    public static function Create($host)
    {
    	return new static($host);
    }

    /**
     * Return an object with the options configured for the Ping (for debug purposes)
     *
     * @return  stdClass
     */
    public function GetPingOptions()
    {
        $options = new stdClass();
        $options->count        = $this->count;
        $options->interval     = $this->interval;
        $options->packet_size  = $this->packet_size;
        $options->timeout      = $this->timeout;
        $options->time_to_live = $this->time_to_live;

        return $options;
    }

    /**
     * Set the total of packets to sent
     *
     * @param  integer  $count
     * @return  $this
     */
    public function Count(int $count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Set interval in seconds between each packet.
     *
     * @param  integer  $interval
     * @return  $this
     */
    public function Interval(float $interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * Set the packet size
     *
     * @param  integer  $size
     * @return  $this
     */
    public function PacketSize(int $size)
    {
        $this->packet_size = $size;

        return $this;
    }

    /**
     * Set the time to wait for a response
     *
     * @param  integer  $seconds 
     * @return  $this
     */
    public function Timeout(int $seconds)
    {
        $this->timeout = $seconds;

        return $this;
    }

    /**
     * Set the TTL value of the IP packet
     *
     * @param  integer  $ttl
     * @return $this
     */
    public function TimeToLive(int $ttl)
    {
        $this->time_to_live = $ttl;

        return $this;
    }

    /**
     * Ping a host
     *
     * @return  void
     */
    public function Run()
    {
    	$command = PingCommand::Create($this->host)
    							->Count($this->count)
    							->Interval($this->interval)
    							->PacketSize($this->packet_size)
    							->Timeout($this->timeout)
    							->TimeToLive($this->time_to_live)
    							->Command();

        exec($command, $exec_result);

        $this->timer->stop();

        // Process the results with the PingParser Class
        $results = PingParser::Create($exec_result)->Parse();

        // Append to the parsed data
        $results->options    = $this->GetPingOptions();
        $results->time_taken = $this->timer->Results();

        //if ($parser->IsUnreachable())
        //{
        //    $results->result = 'Host unreachable';
        //}
        return $results;
    }
}