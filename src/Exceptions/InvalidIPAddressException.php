<?php

namespace Acamposm\Ping\Exceptions;

use Exception;

class InvalidIPAddressException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct('Unknown format for this IP address: '.$message);
    }
}
