<?php
namespace SaadeMotion\Photofolio\Facades;

use Illuminate\Support\Facades\Facade;

class Photofolio extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'photofolio';
    }
}
