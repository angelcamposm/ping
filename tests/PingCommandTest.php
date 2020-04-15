<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\PingCommand;
use PHPUnit\Framework\TestCase;

class PingCommandTest extends TestCase
{
	const HOST = '127.0.0.1';

	const COUNT = 10;

	const INTERVAL = 0.5;

	const SIZE = 128;

	const TIMEOUT = 2;

	const TTL = 128;

	/** @test */
	public function isPingCommandClass()
	{
		$command = PingCommand::Create(Self::HOST);

		$this->assertInstanceOf(PingCommand::class, $command);
	}

	/** @test */
	public function canGetLinuxCommand()
	{
		$command = PingCommand::Create(Self::HOST)->LinuxCommand();

		$this->assertStringContainsString(Self::HOST, $command);
	}

	/** @test */
	public function canGetWindowsCommand()
	{
		$command = PingCommand::Create(Self::HOST)->WindowsCommand();

		$this->assertStringContainsString(Self::HOST, $command);
	}

	/** @test */
	public function canChangeCount()
	{
		$command = PingCommand::Create(Self::HOST)->Count(Self::COUNT);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
			$this->assertStringContainsString('-n '.Self::COUNT, $command->WindowsCommand());
        } else {
			$this->assertStringContainsString('-c '.Self::COUNT, $command->LinuxCommand());
        }

	}

	/** @test */
	public function canChangeInterval()
	{
		$command = PingCommand::Create(Self::HOST)->Interval(Self::INTERVAL);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
        	// AssertTrue because no interval can defined in windows ping
        	$this->assertTrue(true);
        } else {
			$this->assertStringContainsString('-i '.Self::INTERVAL, $command->LinuxCommand());
        }
	}

	/** @test */
	public function canChangePacketSize()
	{
		$command = PingCommand::Create(Self::HOST)->PacketSize(Self::SIZE);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
			$this->assertStringContainsString('-l '.Self::SIZE, $command->WindowsCommand());
        } else {
			$this->assertStringContainsString('-s '.Self::SIZE, $command->LinuxCommand());
        }

	}

	/** @test */
	public function canChangeTimeout()
	{
		$command = PingCommand::Create(Self::HOST)->Timeout(Self::TIMEOUT);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
			$this->assertStringContainsString('-w '.Self::TIMEOUT, $command->WindowsCommand());
        } else {
			$this->assertStringContainsString('-W '.Self::TIMEOUT, $command->LinuxCommand());
        }

	}

	/** @test */
	public function canChangeTimeToLive()
	{
		$command = PingCommand::Create(Self::HOST)->TimeToLive(Self::TTL);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
			$this->assertStringContainsString('-i '.Self::TTL, $command->WindowsCommand());
        } else {
			$this->assertStringContainsString('-t '.Self::TTL, $command->LinuxCommand());
        }
	}
}