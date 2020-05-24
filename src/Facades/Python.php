<?php

namespace tonius\python\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Facade Accessor for Tonius Python.
 *
 * @method static run( string $fileName = null, $options = [])
 */
class Python extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Python';
    }
}
