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

namespace Acamposm\Ping\Exceptions;

use Exception;

class MaxValueException extends Exception
{
    public function __construct()
    {
        parent::__construct('TTL must not exceed 255 value.');
    }
}
