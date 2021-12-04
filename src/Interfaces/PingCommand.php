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

namespace Acamposm\Ping\Interfaces;

use Acamposm\Ping\Exceptions\MaxValueException;
use Acamposm\Ping\Exceptions\NegativeValueException;
use Acamposm\Ping\Exceptions\UnknownOSException;
use Acamposm\Ping\PingCommandBuilder;

interface PingCommand
{
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
    public function count(int $count): PingCommandBuilder;

    /**
     * Wait interval seconds between sending each packet. The default is to wait
     * for one second between each packet normally, or not to wait in flood mode.
     * Only super-user may set interval to values less than 0.2 seconds.
     *
     * @param float $interval
     *
     * @return PingCommandBuilder
     */
    public function interval(float $interval): PingCommandBuilder;

    /**
     * Specifies the number of data bytes to be sent. The default is 56, which
     * translates into 64 ICMP data bytes when combined with the 8 bytes of ICMP
     * header data.
     *
     * @param int $packet_size
     *
     * @return PingCommandBuilder
     */
    public function packetSize(int $packet_size): PingCommandBuilder;

    /**
     * ping only. Set the IP Time to Live.
     *
     * @param int $ttl
     *
     * @throws MaxValueException
     *
     * @return PingCommandBuilder
     */
    public function ttl(int $ttl): PingCommandBuilder;

    /**
     * Time to wait for a response. The option affects only timeout in absence
     * of any responses, otherwise ping waits for two RTTs.
     * (Seconds for Linux OS, Milliseconds for Windows).
     *
     * @param int $timeout
     *
     * @return PingCommandBuilder
     */
    public function timeout(int $timeout): PingCommandBuilder;

    /**
     * Return the Ping Command.
     *
     * @throws UnknownOSException
     *
     * @return string
     */
    public function get(): string;
}
