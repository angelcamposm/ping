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
		$command = PingCommand::Create(PingCommandTest::HOST);

		$this->assertInstanceOf(PingCommand::class, $command);
	}

	/** @test */
	public function canGetLinuxCommand()
	{
		$command = PingCommand::Create(PingCommandTest::HOST)->CommandForLinux();

		$this->assertStringContainsString(PingCommandTest::HOST, $command);
	}

	/** @test */
	public function canGetWindowsCommand()
	{
		$command = PingCommand::Create(PingCommandTest::HOST)->CommandForWindows();

		$this->assertStringContainsString(PingCommandTest::HOST, $command);
	}

	/** @test */
	public function canChangeCount()
	{
		$command = PingCommand::Create(PingCommandTest::HOST)->Count(PingCommandTest::COUNT);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
			$this->assertStringContainsString('-n '.PingCommandTest::COUNT, $command->CommandForWindows());
        } else {
			$this->assertStringContainsString('-c '.PingCommandTest::COUNT, $command->CommandForLinux());
        }
    }

	/** @test */
	public function canChangeInterval()
	{
		$command = PingCommand::Create(PingCommandTest::HOST)->Interval(PingCommandTest::INTERVAL);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
        	// AssertTrue because no interval can defined in windows ping
        	$this->assertTrue(true);
        } else {
			$this->assertStringContainsString('-i '.PingCommandTest::INTERVAL, $command->CommandForLinux());
        }
	}

	/** @test */
	public function canChangePacketSize()
	{
		$command = PingCommand::Create(PingCommandTest::HOST)->PacketSize(PingCommandTest::SIZE);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
			$this->assertStringContainsString('-l '.PingCommandTest::SIZE, $command->CommandForWindows());
        } else {
			$this->assertStringContainsString('-s '.PingCommandTest::SIZE, $command->CommandForLinux());
        }
    }

	/** @test */
	public function canChangeTimeout()
	{
		$command = PingCommand::Create(PingCommandTest::HOST)->Timeout(PingCommandTest::TIMEOUT);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
			$this->assertStringContainsString('-w '.PingCommandTest::TIMEOUT, $command->CommandForWindows());
        } else {
			$this->assertStringContainsString('-W '.PingCommandTest::TIMEOUT, $command->CommandForLinux());
        }
    }

	/** @test */
	public function canChangeTimeToLive()
	{
		$command = PingCommand::Create(PingCommandTest::HOST)->TimeToLive(PingCommandTest::TTL);

        if (in_array(PHP_OS, ['WIN32', 'WINNT', 'Windows'])) {
			$this->assertStringContainsString('-i '.PingCommandTest::TTL, $command->CommandForWindows());
        } else {
			$this->assertStringContainsString('-t '.PingCommandTest::TTL, $command->CommandForLinux());
        }
	}
}
