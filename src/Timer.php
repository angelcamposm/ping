<?php

namespace Acamposm\Ping;

use DateTime;
use Exception;
use stdClass;

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
    protected $stop;

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
     * @throws Exception
     * @retun  float
     */
    public function Stop(): float
    {
        if (! isset($this->start)) {
            throw new Exception('Timer not started.');
        }

        return $this->stop = microtime(true);
    }

    /**
     * Returns an array with the Timer details.
     *
     * @return  stdClass
     */
    public function GetResults(): stdClass
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
