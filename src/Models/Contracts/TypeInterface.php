<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Contracts;

/**
 * Interface TypeInterface
 * @package ShibuyaKosuke\LaravelDdlExport\Models\Contracts
 */
interface TypeInterface
{
    /**
     * @param ColumnInterface $column
     * @return string
     */
    public function convertType(ColumnInterface $column): string;
}
