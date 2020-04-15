<?php

namespace Acamposm\Ping;

use \DateTime;

/**
 * Utility Class to control time elapsed in commands.
 */
class Timer
{
    /**
     * Format for the timestamps.
     *
     * @var  string
     */
    protected $format = 'd-m-Y H:i:s.u';

    /**
     * Timer START.
     *
     * @var  float
     */
    protected $start;

    /**
     * Timer END.
     *
     * @var  float
     */
    protected $end;

    public function __construct()
    {
        return $this;
    }

    /**
     * Start the Timer.
     */
    public function Start()
    {
        $this->start = microtime(true);

        return $this->start;
    }

    /**
     * Stop the Timer.
     */
    public function Stop()
    {
        $this->stop = microtime(true);

        return $this->stop;
    }

    /**
     * Returns an array with the Timer details.
     *
     * @return  array
     */
    public function GetResults(): array
    {
        if (! isset($this->stop)) {
            $this->stop = microtime(true);
        }

        $start = DateTime::createFromFormat('U.u', $this->start);

        $stop = DateTime::createFromFormat('U.u', $this->stop);

        $time_elapsed = $this->stop - $this->start;

        return [
            'start' => $start->format($this->format),
            'stop' => $stop->format($this->format),
            'time' => $time_elapsed,
        ];
    }
}
