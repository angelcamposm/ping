<?php

namespace Acamposm\Ping\Interfaces;

use Acamposm\Ping\PingCommandBuilder;

interface PingCommand
{
    public function count(int $count): PingCommandBuilder;

    public function interval(float $interval): PingCommandBuilder;

    public function packetSize(int $packet_size): PingCommandBuilder;

    public function ttl(int $ttl): PingCommandBuilder;

    public function timeout(int $timeout): PingCommandBuilder;

    public function get(): string;
}
