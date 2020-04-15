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

class Ping
{
    /**
     * The IP address of the host.
     *
     * @var  string
     */
    private $host;

    /**
     * Stop after sending count ECHO_REQUEST packets.
     *
     * @var  int
     */
    private $count = 4;

    /**
     * Wait interval seconds between sending each packet. The default is to
     * wait for one second between each packet normally, or not to wait in
     * flood mode.
     * Only super-user may set interval to values less than 0.2 seconds.
     *
     * @var  int
     */
    private $interval = 1;

    /**
     * Determine if is a Windows based Operating System.
     *
     * @var bool
     */
    protected $is_windows_os = false;

    /**
     * Specifies the number of data bytes to be sent.
     * The default is 56, which translates into 64 ICMP data bytes when
     * combined with the 8 bytes of ICMP header data.
     *
     * @var  int
     */
    private $packet_size = 64;

    /**
     * Time to wait for a response, in seconds. The option affects only
     * timeout in absence of any responses, otherwise ping waits for two RTTs.
     *
     * @var  int
     */
    private $timeout = 5;

    /**
     * The TTL value of an IP packet represents the maximum number of IP
     * routers that the packet can go through before being thrown away.
     * In current practice you can expect each router in the Internet to
     * decrement the TTL field by exactly one.
     *
     * @var  int
     */
    private $time_to_live = 128;

    /**
     * The Exit from the exec command.
     *
     * @var  string[]
     */
    private $exec_result;

    /**
     * An object to allow us to control the total execution time.
     *
     * @var  stdClass
     */
    private $timer;

    public function __construct($host)
    {
        // Determine if is a Windows based Operating System
        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
            $this->is_windows_os = true;
        }

        $this->host = $host;
        $this->timer = new Timer();
    }

    public static function Create($host)
    {
        return new static($host);
    }

    /**
     * Return an object with the options configured for the Ping (for debug purposes).
     *
     * @return  stdClass
     */
    public function GetPingOptions()
    {
        return [
            'count' => $this->count,
            'interval' => $this->interval,
            'packet_size' => $this->packet_size,
            'target_ip' => $this->host,
            'timeout' => $this->timeout,
            'time_to_live' => $this->time_to_live,
        ];
    }

    /**
     * Set the total of packets to sent.
     *
     * @param  int  $count
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
     * @param  int  $interval
     * @return  $this
     */
    public function Interval(float $interval)
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * Set the packet size.
     *
     * @param  int  $size
     * @return  $this
     */
    public function PacketSize(int $size)
    {
        $this->packet_size = $size;

        return $this;
    }

    /**
     * Set the time to wait for a response.
     *
     * @param  int  $seconds
     * @return  $this
     */
    public function Timeout(int $seconds)
    {
        $this->timeout = $seconds;

        return $this;
    }

    /**
     * Set the TTL value of the IP packet.
     *
     * @param  int  $ttl
     * @return $this
     */
    public function TimeToLive(int $ttl)
    {
        $this->time_to_live = $ttl;

        return $this;
    }

    /**
     * Returns the Ping command to be used.
     *
     * @return  string
     */
    private function GetPingCommand(): string
    {
        $command = PingCommand::Create($this->host)
                                ->Count($this->count)
                                ->Interval($this->interval)
                                ->PacketSize($this->packet_size)
                                ->Timeout($this->timeout)
                                ->TimeToLive($this->time_to_live);

        if ($is_windows_os) {
            return $command->WindowsCommand();
        }

        return $command->LinuxCommand();
    }

    /**
     * Call to specific parser based on operating system.
     *
     * @param  array  $ping
     */
    private function ParseResults(array $ping): object
    {
        if ($is_windows_os) {
            return PingParserForWindows::Create($exec_result)->Parse();
        }

        return PingParserForLinux::Create($ping)->Parse();
    }

    /**
     * Ping a host.
     *
     * @return  void
     */
    public function Run()
    {
        $command = $this->GetPingCommand();

        exec($command, $exec_result);

        $this->timer->stop();

        $results = $this->ParseResults();

        // Append to the parsed data
        $results->options = $this->GetPingOptions();
        $results->time_taken = $this->timer->Results();

        return $results;
    }
}
