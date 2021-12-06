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

class IPAddress
{
    public const IPV4_SEPARATOR = '.';
    public const IPV6_SEPARATOR = ':';

    /**
     * Performs the validation of the IP Address.
     *
     * @param string $ip_address
     *
     * @return bool
     */
    public static function Validate(string $ip_address): bool
    {
        if (str_contains($ip_address, IPAddress::IPV4_SEPARATOR)) {
            return self::validateIPv4Address($ip_address);
        }

        if (str_contains($ip_address, IPAddress::IPV6_SEPARATOR)) {
            return self::validateIPv6Address($ip_address);
        }

        return false;
    }

    /**
     * Performs a IPv4 validation.
     *
     * Validate an IPv4 address
     *
     * @param string $ip_address
     *
     * @return bool
     */
    private static function validateIPv4Address(string $ip_address): bool
    {
        if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === false) {
            return false;
        }

        return true;
    }

    /**
     * Performs a IPv6 validation.
     *
     * @param string $ip_address
     *
     * @return bool
     */
    private static function validateIPv6Address(string $ip_address): bool
    {
        if (filter_var($ip_address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false) {
            return false;
        }

        return true;
    }
}
