<?php

namespace Acamposm\Ping;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Acamposm\Ping\Skeleton\SkeletonClass
 */
class PingFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ping';
    }
}
