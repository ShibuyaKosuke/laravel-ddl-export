<?php

namespace ShibuyaKosuke\LaravelDdlExport\Facades;

use Illuminate\Support\Facades\Facade;

class Type extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'shibuyakosuke.types';
    }
}