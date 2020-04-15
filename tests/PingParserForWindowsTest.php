<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\PingParserForWindows;
use PHPUnit\Framework\TestCase;

class PingParserForWindowsTest extends TestCase
{
	/** @test */
	public function isPingParserClass()
	{
    	$ping = [];

    	$parser = new PingParserForWindows($ping);

    	$this->assertInstanceOf(PingParserForWindows::class, $parser);
	}

	/** @test */
	public function canParseWindowsPing()
	{
		$ping = [
			'Haciendo ping a 127.0.0.1 con 32 bytes de datos:',
			'Respuesta desde 127.0.0.1: bytes=32 tiempo<1m TTL=128',
			'Respuesta desde 127.0.0.1: bytes=32 tiempo<1m TTL=128',
			'Respuesta desde 127.0.0.1: bytes=32 tiempo<1m TTL=128',
			'Respuesta desde 127.0.0.1: bytes=32 tiempo<1m TTL=128',
			'',
			'Estadísticas de ping para 127.0.0.1:',
			'    Paquetes: enviados = 4, recibidos = 4, perdidos = 0',
			'    (0% perdidos),',
			'Tiempos aproximados de ida y vuelta en milisegundos:',
			'    Mínimo = 0ms, Máximo = 0ms, Media = 0ms',
		];

    	$parser = new PingParserForWindows($ping);

    	$this->assertIsObject($parser->Parse());
	}
}