<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\IndexInterface;

class PostgresqlIndex extends Model implements IndexInterface
{
    protected $table = 'information_schema.table_constraints';

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('database', function (Builder $builder) {
            $builder->join('information_schema.key_column_usage', function ($join) {
                $join->on('table_constraints.constraint_catalog', '=', 'key_column_usage.constraint_catalog')
                    ->whereColumn('table_constraints.constraint_schema', '=', 'key_column_usage.constraint_schema')
                    ->whereColumn('table_constraints.constraint_name', '=', 'key_column_usage.constraint_name');
            });
        });
    }
}