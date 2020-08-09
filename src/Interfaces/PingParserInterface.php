<?php

namespace Acamposm\Ping\Interfaces;

interface PingParserInterface
{
    /**
     * Returns the Ping execution result parsed as object
     *
     * @return object
     */
    public function parse(): object;
}