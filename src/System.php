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
 * @version  2.1.2
 */

namespace Acamposm\Ping;

class System
{
    /**
     * Return TRUE if OS is Linux.
     *
     * @return bool
     */
    public static function isLinux(): bool
    {
        return PHP_OS_FAMILY === 'Linux';
    }

    /**
     * Return TRUE if OS is Apple OSX.
     *
     * @return bool
     */
    public static function isOSX(): bool
    {
        return PHP_OS_FAMILY === 'OSX';
    }

    /**
     * Return TRUE if OS is Solaris.
     *
     * @return bool
     */
    public static function isSolaris(): bool
    {
        return PHP_OS_FAMILY === 'Solaris';
    }

    /**
     * Return TRUE if OS is Windows.
     *
     * @return bool
     */
    public static function isWindows(): bool
    {
        return PHP_OS_FAMILY === 'Windows';
    }
}
