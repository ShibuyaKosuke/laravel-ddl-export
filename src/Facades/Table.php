<?php

namespace ShibuyaKosuke\LaravelDdlExport\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Table
 * @package ShibuyaKosuke\LaravelDdlExport\Facades
 */
class Table extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'shibuyakosuke.table';
    }
}