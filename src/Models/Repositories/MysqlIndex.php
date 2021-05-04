<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\IndexInterface;

/**
 * Class MysqlIndex
 * @package ShibuyaKosuke\LaravelDdlExport\Models\Repositories
 */
class MysqlIndex extends Model implements IndexInterface
{
    protected $table = 'information_schema.key_column_usage';

    /**
     * @var string[]
     */
    protected $appends = [
        'column_name'
    ];

    /**
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        $key = strtoupper($key);
        return $this->getAttribute($key);
    }

    /**
     * @return boolean
     */
    public function isPrimary(): bool
    {
        return $this->CONSTRAINT_NAME === 'PRIMARY';
    }

    /**
     * @return boolean
     */
    public function isUnique(): bool
    {
        return Str::is('*_unique', $this->CONSTRAINT_NAME);
    }
}
