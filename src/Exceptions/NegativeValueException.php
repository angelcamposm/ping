<?php

namespace Acamposm\Ping\Exceptions;

use Exception;

class NegativeValueException extends Exception
{
    public function __construct()
    {
        parent::__construct('The value of the count parameter must be positive value.');
    }
}
