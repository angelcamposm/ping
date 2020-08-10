<?php

/**
 * @author Angel Campos Muñoz <angel.campos.m@outlook.com>
 * @requires PHP 7.2.0
 */

namespace Acamposm\Ping;

use Acamposm\Ping\Exceptions\TimerNotStartedException;
use DateTime;

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
    protected string $format = 'd-m-Y H:i:s.u';

    /**
     * Timer START.
     *
     * @var  float
     */
    protected float $start;

    /**
     * Timer END.
     *
     * @var  float
     */
    protected float $stop;

    /**
     * Timer constructor.
     */
    public function __construct()
    {
        return $this;
    }

    /**
     * Start the Timer.
     *
     * @return  float
     */
    public function Start(): float
    {
        return $this->start = microtime(true);
    }

    /**
     * Stop the Timer.
     *
     * @throws TimerNotStartedException
     * @retun  float
     */
    public function Stop(): float
    {
        if (! isset($this->start)) throw new TimerNotStartedException();

        return $this->stop = microtime(true);
    }

    /**
     * Returns an array with the Timer details.
     *
     * @return  object
     */
    public function GetResults(): object
    {
        if (! isset($this->stop)) {
            $this->stop = microtime(true);
        }

        $start = DateTime::createFromFormat('U.u', $this->start);

        $stop = DateTime::createFromFormat('U.u', $this->stop);

        $time_elapsed = $this->stop - $this->start;

        return (object) [
            'start' => (object) [
                'as_float' => $this->start,
                'human_readable' => $start->format($this->format),
            ],
            'stop' => (object) [
                'as_float' => $this->stop,
                'human_readable' => $stop->format($this->format),
            ],
            'time' => (float) round($time_elapsed, 3, PHP_ROUND_HALF_DOWN),
        ];
    }
}
