<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\Ping;
use Acamposm\Ping\PingCommand;
use Acamposm\Ping\PingFacade;
use Acamposm\Ping\PingParserForLinux;
use Acamposm\Ping\PingParserForWindows;
use Acamposm\Ping\Timer;
use PHPUnit\Framework\TestCase;

class InstanceOfTest extends TestCase
{
	/**
	 * Use loopback IP for test as valid IP address
	 *
	 * @var  string
	 */
	protected $localhost = '127.0.0.1';

	/** @test */
	public function isPingClass()
	{
		$ping = new Ping($this->localhost);

		$this->assertInstanceOf(Ping::class, $ping);
	}

	/** @test */
	public function isPingCommandClass()
	{
		$command = new PingCommand($this->localhost);

		$this->assertInstanceOf(PingCommand::class, $command);
	}

    /** @test */
    public function isPingParserForLinuxClass()
    {
    	$ping = [];

    	$parser = new PingParserForLinux($ping);

    	$this->assertInstanceOf(PingParserForLinux::class, $parser);
    }

    /** @test */
    public function isPingParserForWindowsClass()
    {
        $ping = [];

        $parser = new PingParserForWindows($ping);

        $this->assertInstanceOf(PingParserForWindows::class, $parser);
    }

    /** @test */
    public function isPingFacadeClass()
    {
    	$facade = new PingFacade();

    	$this->assertInstanceOf(PingFacade::class, $facade);
    }

    /** @test */
    public function isTimerClass()
    {
    	$timer = new Timer();

    	$this->assertInstanceOf(Timer::class, $timer);
    }
}