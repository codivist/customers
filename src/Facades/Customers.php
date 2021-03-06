<?php

namespace Codivist\Modules\Customers\Facades;

use Illuminate\Support\Facades\Facade;

class Customers extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Customers';
    }
}
