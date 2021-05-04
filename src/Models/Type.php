<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models;

use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ColumnInterface;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\TypeInterface;

/**
 * Class Type
 * @package ShibuyaKosuke\LaravelDdlExport\Models
 */
class Type
{
    /**
     * @var TypeInterface
     */
    private TypeInterface $type;

    /**
     * Type constructor.
     * @param TypeInterface $type
     */
    public function __construct(TypeInterface $type)
    {
        $this->type = $type;
    }

    /**
     * @param ColumnInterface $column
     * @return string
     */
    public function convertType(ColumnInterface $column): string
    {
        return $this->type->convertType($column);
    }
}
