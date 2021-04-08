<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Database\Eloquent\Model;
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
}