<?php

/**
 * @author Angel Campos Muñoz <angel.campos.m@outlook.com>
 * @requires PHP 7.2.0
 */

namespace Acamposm\Ping;

class System
{
    /**
     * Return TRUE if OS is Linux.
     *
     * @return bool
     */
    public static function isLinux(): bool
    {
        return PHP_OS_FAMILY === 'Linux';
    }

    /**
     * Return TRUE if OS is Apple OSX.
     *
     * @return bool
     */
    public static function isOSX(): bool
    {
        return PHP_OS_FAMILY === 'OSX';
    }

    /**
     * Return TRUE if OS is Solaris.
     *
     * @return bool
     */
    public static function isSolaris(): bool
    {
        return PHP_OS_FAMILY === 'Solaris';
    }

    /**
     * Return TRUE if OS is Windows.
     *
     * @return bool
     */
    public static function isWindows(): bool
    {
        return PHP_OS_FAMILY === 'Windows';
    }
}
