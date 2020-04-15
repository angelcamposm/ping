<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\PingParserForLinux;
use PHPUnit\Framework\TestCase;

class PingParserForLinuxTest extends TestCase
{
	/** @test */
	public function isPingParserClass()
	{
    	$ping = [];

    	$parser = new PingParserForLinux($ping);

    	$this->assertInstanceOf(PingParserForLinux::class, $parser);
	}

	/** @test */
	public function canParseWindowsPing()
	{
		$ping = [
			'PING 127.0.0.1 (127.0.0.1) 56(84) bytes of data.',
			'64 bytes from 127.0.0.1: icmp_seq=1 ttl=64 time=0.052 ms',
			'64 bytes from 127.0.0.1: icmp_seq=2 ttl=64 time=0.077 ms',
			'64 bytes from 127.0.0.1: icmp_seq=3 ttl=64 time=0.056 ms',
			'64 bytes from 127.0.0.1: icmp_seq=4 ttl=64 time=0.044 ms',
			'',
			'--- 127.0.0.1 ping statistics ---',
			'4 packets transmitted, 4 received, 0% packet loss, time 58ms',
			'rtt min/avg/max/mdev = 0.044/0.057/0.077/0.013 ms',
		];

    	$parser = new PingParserForLinux($ping);

    	$this->assertIsObject($parser->Parse());
	}
}