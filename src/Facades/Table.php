<?php

namespace ShibuyaKosuke\LaravelDdlExport\Facades;

use Illuminate\Support\Facades\Facade;

class Table extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'shibuyakosuke.table';
    }
}