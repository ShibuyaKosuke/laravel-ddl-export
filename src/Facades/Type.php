<?php

namespace ShibuyaKosuke\LaravelDdlExport\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Type
 * @package ShibuyaKosuke\LaravelDdlExport\Facades
 */
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