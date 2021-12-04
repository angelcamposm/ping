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

namespace Acamposm\Ping;

use Acamposm\Ping\Exceptions\InvalidIPAddressException;
use Acamposm\Ping\Exceptions\MaxValueException;
use Acamposm\Ping\Exceptions\NegativeValueException;
use Acamposm\Ping\Exceptions\UnknownOSException;
use Acamposm\Ping\Interfaces\PingCommand;

class PingCommandBuilder implements PingCommand
{
    protected int $count;
    protected ?string $host;
    protected float $interval;
    protected int $packet_size;
    protected int $ttl;
    protected int $timeout;
    protected int $version;

    /**-
     * PingCommand constructor.
     *
     * @param string|null $host
     * @throws InvalidIPAddressException
     */
    public function __construct(?string $host = null)
    {
        if ($this->isValidIPAddress($host)) {
            $this->host = $host;
            $this->setIPAddressVersion();
        } else {
            if (str_ends_with($host, '/')) {
                $host = substr($host, 0, strlen($host) - 1);
            }

            // We assume that is an URL...
            //TODO: Needs URL validation
            $pattern = '/^http:\/\/|^https:\/\//';

            if (preg_match($pattern, $host)) {
                $this->host = preg_replace($pattern, '', $host);
            } else {
                $this->host = $host;
            }
        }

        $this->count = config('ping.count');
        $this->interval = config('ping.interval');
        $this->packet_size = config('ping.packet_size');
        $this->timeout = config('ping.timeout');
        $this->ttl = config('ping.ttl');
    }

    /**
     * Validates an IP Address.
     *
     * @param string|null $ip_address
     *
     * @throws InvalidIPAddressException
     *
     * @return bool
     */
    private function isValidIPAddress(?string $ip_address = null): bool
    {
        return IPAddress::Validate($ip_address);
    }

    /**
     * Select the appropriate IP version.
     */
    private function setIPAddressVersion(): void
    {
        if (strpos($this->host, IPAddress::IPV4_SEPARATOR) > 0) {
            $this->useIPv4();
        } elseif (strpos($this->host, IPAddress::IPV6_SEPARATOR) > 0) {
            $this->useIPv6();
        }
    }

    /**
     * Set IP protocol version 4.
     */
    private function useIPv4(): void
    {
        $this->version = 4;
    }

    /**
     * Set IP protocol version 6.
     */
    private function useIPv6(): void
    {
        $this->version = 6;
    }

    /**
     * Stop after sending count ECHO_REQUEST packets. With deadline option, ping
     * waits for count ECHO_REPLY packets, until the timeout expires.
     *
     * @param int $count
     *
     * @throws NegativeValueException
     *
     * @return PingCommandBuilder
     */
    public function count(int $count): PingCommandBuilder
    {
        if ($count < 0) {
            throw new NegativeValueException();
        }

        $this->count = $count;

        return $this;
    }

    /**
     * Wait interval seconds between sending each packet. The default is to wait
     * for one second between each packet normally, or not to wait in flood mode.
     * Only super-user may set interval to values less than 0.2 seconds.
     *
     * @param float $interval
     *
     * @return PingCommandBuilder
     */
    public function interval(float $interval): PingCommandBuilder
    {
        $this->interval = $interval;

        return $this;
    }

    /**
     * Specifies the number of data bytes to be sent. The default is 56, which
     * translates into 64 ICMP data bytes when combined with the 8 bytes of ICMP
     * header data.
     *
     * @param int $packet_size
     *
     * @return PingCommandBuilder
     */
    public function packetSize(int $packet_size): PingCommandBuilder
    {
        $this->packet_size = $packet_size;

        return $this;
    }

    /**
     * ping only. Set the IP Time to Live.
     *
     * @param int $ttl
     *
     * @throws MaxValueException
     *
     * @return PingCommandBuilder
     */
    public function ttl(int $ttl): PingCommandBuilder
    {
        if ($ttl > 255) {
            throw new MaxValueException();
        }

        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Time to wait for a response. The option affects only timeout in absence
     * of any responses, otherwise ping waits for two RTTs.
     * (Seconds for Linux OS, Milliseconds for Windows).
     *
     * @param int $timeout
     *
     * @return PingCommandBuilder
     */
    public function timeout(int $timeout): PingCommandBuilder
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Returns the Linux Ping Command.
     *
     * @return string
     */
    private function getLinuxCommand(): string
    {
        $command = ['ping -n'];

        (!isset($this->version)) ?: array_push($command, '-'.$this->version);
        (!isset($this->count)) ?: array_push($command, '-c '.$this->count);
        (!isset($this->interval)) ?: array_push($command, '-i '.$this->interval);
        (!isset($this->packet_size)) ?: array_push($command, '-s '.$this->packet_size);
        (!isset($this->timeout)) ?: array_push($command, '-W '.$this->timeout);
        (!isset($this->ttl)) ?: array_push($command, '-t '.$this->ttl);

        $command[] = $this->host;

        return implode(' ', $command);
    }

    /**
     * Returns the OSX Ping Command.
     *
     * @return string
     */
    private function getOSXCommand(): string
    {
        $command = ['ping'];

        (!isset($this->version)) ?: array_push($command, '-'.$this->version);
        (!isset($this->count)) ?: array_push($command, '-c '.$this->count);
        (!isset($this->interval)) ?: array_push($command, '-i '.$this->interval);
        (!isset($this->packet_size)) ?: array_push($command, '-s '.$this->packet_size);
        (!isset($this->timeout)) ?: array_push($command, '-t '.($this->timeout * 1000));
        (!isset($this->ttl)) ?: array_push($command, '-m '.$this->ttl);

        $command[] = $this->host;

        return implode(' ', $command);
    }

    /**
     * Returns the Windows Ping Command.
     *
     * @return string
     */
    private function getWindowsCommand(): string
    {
        $command = ['ping'];

        (!isset($this->version)) ?: array_push($command, '-'.$this->version);
        (!isset($this->count)) ?: array_push($command, '-n '.$this->count);
        (!isset($this->packet_size)) ?: array_push($command, '-l '.$this->packet_size);
        (!isset($this->timeout)) ?: array_push($command, '-w '.($this->timeout * 1000));
        (!isset($this->ttl)) ?: array_push($command, '-i '.$this->ttl);

        $command[] = $this->host;

        return implode(' ', $command);
    }

    /**
     * Return an object with the options.
     *
     * @return object
     */
    public function getOptions(): object
    {
        $options = [
            'host' => $this->host,
        ];

        (!isset($this->count)) ?: $options['count'] = $this->count;
        (!isset($this->interval)) ?: $options['interval'] = $this->interval;
        (!isset($this->packet_size)) ?: $options['packet_size'] = $this->packet_size;
        (!isset($this->timeout)) ?: $options['timeout'] = $this->timeout;
        (!isset($this->ttl)) ?: $options['ttl'] = $this->ttl;
        (!isset($this->version)) ?: $options['version'] = $this->version;

        return (object) $options;
    }

    /**
     * Return the Ping Command.
     *
     * @throws UnknownOSException
     *
     * @return string
     */
    public function get(): string
    {
        if (System::isLinux()) {
            return $this->getLinuxCommand();
        }

        if (System::isOSX()) {
            return $this->getOSXCommand();
        }

        if (System::isWindows()) {
            return $this->getWindowsCommand();
        }

        throw new UnknownOSException();
    }
}
