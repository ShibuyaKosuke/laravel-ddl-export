<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ColumnInterface;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\TypeInterface;

/**
 * Class MysqlType
 * @package ShibuyaKosuke\LaravelDdlExport\Models\Repositories
 */
class MysqlType implements TypeInterface
{
    /**
     * @var \string[][]
     */
    private $types = [
        'integer' => [
            'bigint',
            'mediumint',
            'smallint',
            'tinyint',
            'int',
            'year',
        ],
        'numeric' => [
            'numeric',
            'decimal',
            'double',
        ],
        'string' => [
            'varchar',
            'char',
            'text',
            'longtext',
        ],
        'boolean' => [
            'bool',
        ],
        'date' => [
            'time',
            'date',
            'datetime',
            'timestamp',
        ],
        'json' => [
            'json',
        ],
    ];

    /**
     * @param ColumnInterface $column
     * @return string
     * @throws \Exception
     */
    public function convertType(ColumnInterface $column): string
    {
        foreach ($this->types as $index => $types) {
            if (in_array($column->type, $types, true)) {
                return $index;
            }
        }
        throw new \Exception('Type not found!: ' . $column->type);
    }
}
