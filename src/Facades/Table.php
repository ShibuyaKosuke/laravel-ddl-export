<?php

namespace ShibuyaKosuke\LaravelDdlExport\Facades;

use Illuminate\Support\Facades\Facade;

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