<?php

namespace ShibuyaKosuke\LaravelDdlExport\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class CreateView
 * @package ShibuyaKosuke\LaravelDdlExport\Facades
 */
class CreateView extends Facade
{
    /**
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return 'shibuyakosuke.constraints';
    }
}