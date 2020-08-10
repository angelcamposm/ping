<?php

namespace Acamposm\Ping\Exceptions;

use Exception;

class TimerNotStartedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Timer not started.');
    }
}
