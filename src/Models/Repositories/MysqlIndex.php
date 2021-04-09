<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\IndexInterface;

class MysqlIndex extends Model implements IndexInterface
{
    protected $table = 'information_schema.key_column_usage';

    protected $appends = [
        'column_name'
    ];

    public function __get($key)
    {
        $key = strtoupper($key);
        return $this->getAttribute($key);
    }

    public function isPrimary(): bool
    {
        return $this->CONSTRAINT_NAME === 'PRIMARY';
    }

    public function isUnique(): bool
    {
        return Str::is('*_unique', $this->CONSTRAINT_NAME);
    }
}