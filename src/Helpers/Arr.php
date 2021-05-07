<?php

namespace ShibuyaKosuke\LaravelDdlExport\Helpers;

/**
 * Class Arr
 * @package ShibuyaKosuke\LaravelDdlExport\Helpers
 */
class Arr
{
    /**
     * @param array $array
     * @return string
     */
    public static function export(array $array): string
    {
        $string = var_export($array, true);
        return str_replace(["\n  array (", "array (", ')', '  '], ['[', '[', ']', '    '], $string);
    }
}
