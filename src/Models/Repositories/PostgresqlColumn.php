<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ColumnInterface;
use ShibuyaKosuke\LaravelDdlExport\Models\Table;

/**
 * Class PostgresqlColumn
 * @package ShibuyaKosuk\LaravelDdlExport\Models\Repositories
 */
class PostgresqlColumn extends Model implements ColumnInterface
{
    /**
     * @var string
     */
    protected $table = 'information_schema.columns';

    protected $appends = [
        'is_primary_key',
        'is_unique',
        'name',
        'type',
        'length',
        'nullable',
        'not_null',
        'default',
        'comment',
    ];

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('database', function (Builder $builder) {
            $connection = Schema::getConnection();
            $databaseName = $connection->getDatabaseName();
            $builder->where([
                ['table_schema', '=', 'public'],
                ['table_catalog', '=', $databaseName]
            ]);
        });
    }

    public function table(): Table
    {
        return $this->table_name;
    }

    public function getIsPrimaryKeyAttribute(): bool
    {
        return $this->primaryKey === $this->column_name;
    }

    public function getIsUniqueAttribute(): bool
    {
        return false;
    }

    public function getNameAttribute(): string
    {
        return $this->column_name;
    }

    public function getTypeAttribute(): string
    {
        return $this->udt_name;
    }

    public function getLengthAttribute(): ?int
    {
        return $this->character_maximum_length;
    }

    public function getNullableAttribute(): bool
    {
        return $this->is_nullable === 'YES';
    }

    public function getNotNullAttribute(): bool
    {
        return $this->is_nullable === 'NO';
    }

    public function getDefaultAttribute()
    {
        return $this->column_default;
    }

    public function getCommentAttribute(): string
    {
        $row = DB::table('pg_description')
            ->join('pg_stat_all_tables', 'pg_stat_all_tables.relid', '=', 'pg_description.objoid')
            ->join('pg_attribute', 'pg_attribute.attrelid', '=', 'pg_description.objoid')
            ->whereColumn('pg_description.objoid', 'pg_attribute.attrelid')
            ->whereColumn('pg_description.objsubid', 'pg_attribute.attnum')
            ->where('pg_stat_all_tables.schemaname', 'public')
            ->where('pg_stat_all_tables.relname', $this->table_name)
            ->where('pg_attribute.attname', $this->column_name)
            ->first('description');

        return $row->description ?? '';
    }
}