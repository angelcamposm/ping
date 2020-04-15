<?php

namespace Acamposm\Ping\Tests;

use Acamposm\Ping\Timer;
use PHPUnit\Framework\TestCase;

class TimerTest extends TestCase
{
    /** @test */
    public function isTimerClass()
    {
        $timer = new Timer();

        $this->assertInstanceOf(Timer::class, $timer);
    }

    /** @test */
    public function canStartTimer()
    {
        $timer = new Timer();

        $this->assertIsFloat($timer->Start());
    }

    /** @test */
    public function canStopTimer()
    {
        $timer = new Timer();

        $this->assertIsFloat($timer->Stop());
    }

    /** @test */
    public function getTimerGreatherThan()
    {
        $timer = new Timer();

        $start = $timer->Start();

        usleep(500000);

        $stop = $timer->Stop();

        $this->assertGreaterThan($start, $stop);
    }

    /** @test */
    public function getTimerResults()
    {
        $timer = new Timer();

        $start = $timer->Start();

        $stop = $timer->Stop();

        $this->assertIsArray($timer->GetResults());
    }

    /** @test */
    public function GetResultsWithOutStoppingTimer()
    {
        $timer = new Timer();

        $start = $timer->Start();

        $this->assertIsArray($timer->GetResults());
    }
}
