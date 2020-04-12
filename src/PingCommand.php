<?php

namespace Acamposm\Ping;

class PingCommand
{
    /**
     * Stop after sending count ECHO_REQUEST packets.
     *
     * @var  integer
     */
    protected $count = 4;

    /**
     * The IP address of the host
     *
     * @var  string
     */
    private $host;

    /**
     * Wait interval seconds between sending each packet. The default is to 
     * wait for one second between each packet normally, or not to wait in 
     * flood mode. 
     * Only super-user may set interval to values less than 0.2 seconds.
     *
     * @var  integer
     */
    protected $interval = 1;

    /**
     * Specifies the number of data bytes to be sent. 
     * The default is 56, which translates into 64 ICMP data bytes when 
     * combined with the 8 bytes of ICMP header data.
     *
     * @var  integer
     */
    protected $packet_size = 64;

    /**
     * Time to wait for a response, in seconds. The option affects only 
     * timeout in absence of any responses, otherwise ping waits for two RTTs.
     *
     * @var  integer
     */
    protected $timeout = 5;

    /**
     * The TTL value of an IP packet represents the maximum number of IP 
     * routers that the packet can go through before being thrown away.  
     * In current practice you can expect each router in the Internet to 
     * decrement the TTL field by exactly one.
     *
     * @var  integer
     */
    protected $time_to_live = 128;

    function __construct($host)
    {
    	$this->host = $host;
    }

    public static function Create($host)
    {
    	return new static($host);
    }

    /**
     * Set the total of packets to sent
     *
     * @param  integer  $count
     * @return  Acamposm\PingCommand
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
     * @return  Acamposm\PingCommand
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
     * @return  Acamposm\PingCommand
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
     * @return  Acamposm\PingCommand
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
     * @return  Acamposm\PingCommand
     */
    public function TimeToLive(int $ttl)
    {
        $this->time_to_live = $ttl;

        return $this;
    }

    /**
     * Returns the Ping Command to be Used
     *
     * @return  string
     */
    public function Command(): string
    {
        $command = [
            'ping -4 -n',
            '-c ' . escapeshellcmd($this->count),
            '-i ' . escapeshellcmd($this->interval),
            '-s ' . escapeshellcmd($this->packet_size),
            '-t ' . escapeshellcmd($this->time_to_live),
            '-W ' . escapeshellcmd($this->timeout),
            escapeshellcmd($this->host)
        ];

        return implode(' ', $command);
    }
}