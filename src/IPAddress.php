<?php

namespace Acamposm\Ping;

use acamposm\Ping\Exceptions\InvalidIPAddressException;
use Exception;

class IPAddress
{
    const IPV4_SEPARATOR = '.';
    const IPV6_SEPARATOR = ':';

    /**
     * Performs the validation of the IP Address.
     *
     * @param string|null $ip_address
     * @return bool
     * @throws InvalidIPAddressException
     * @throws Exception
     */
    public static function Validate(?string $ip_address = null): bool
    {
        if ($ip_address === null) {
            throw new Exception('A host must be specified');
        }
        if (strpos($ip_address, IPAddress::IPV4_SEPARATOR) > 0) {
            return self::validateIPv4Address($ip_address);
        } elseif (strpos($ip_address, IPAddress::IPV6_SEPARATOR) > 0) {
            return self::validateIPv6Address($ip_address);
        } else {
            throw new InvalidIPAddressException('Unknown format');
        }
    }

    /**
     * Performs a IPv4 validation.
     *
     * Validate an IPv4 address
     *
     * @param string $ip_address
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
