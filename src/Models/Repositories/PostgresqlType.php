<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ColumnInterface;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\TypeInterface;

/**
 * Class PostgresqlType
 * @package ShibuyaKosuke\LaravelDdlExport\Models\Repositories
 */
class PostgresqlType implements TypeInterface
{
    /**
     * @var \string[][]
     */
    private $types = [
        'integer' => [
            'int2',
            'int4',
            'int8',
        ],
        'numeric' => [
            'numeric',
        ],
        'string' => [
            'varchar',
            'bpchar',
            'text',
        ],
        'boolean' => [
            'bool',
        ],
        'date' => [
            'time',
            'date',
            'timestamp',
        ],
        'float' => [
            'float8',
        ]
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
