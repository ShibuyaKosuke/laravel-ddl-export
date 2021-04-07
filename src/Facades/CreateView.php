<?php

namespace ShibuyaKosuke\LaravelDdlExport\Facades;

use Illuminate\Support\Facades\Facade;

class CreateView extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'shibuyakosuke.constraints';
    }
}