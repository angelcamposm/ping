<?php

namespace Acamposm\Ping\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Acamposm\Ping\Facades\Skeleton\SkeletonClass
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
