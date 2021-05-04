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
 * @property-read Table table_name
 * @property-read string column_key
 * @property-read string column_name
 * @property-read string column_type
 * @property-read string character_maximum_length
 * @property-read string is_nullable
 * @property-read string column_default
 * @property-read string column_comment
 * @property-read string table_catalog
 * @property-read string udt_name
 */
class PostgresqlColumn extends Model implements ColumnInterface
{
    /**
     * @var string
     */
    protected $table = 'information_schema.columns';

    /**
     * @var string[]
     */
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
        'foreign',
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

    /**
     * @return Table
     */
    public function table(): Table
    {
        return $this->table_name;
    }

    /**
     * @return boolean
     */
    public function getIsPrimaryKeyAttribute(): bool
    {
        return $this->primaryKey === $this->column_name;
    }

    /**
     * @return boolean
     */
    public function getIsUniqueAttribute(): bool
    {
        return false;
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->column_name;
    }

    /**
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return $this->udt_name;
    }

    /**
     * @return integer|null
     */
    public function getLengthAttribute(): ?int
    {
        return $this->character_maximum_length;
    }

    /**
     * @return boolean
     */
    public function getNullableAttribute(): bool
    {
        return $this->is_nullable === 'YES';
    }

    /**
     * @return boolean
     */
    public function getNotNullAttribute(): bool
    {
        return $this->is_nullable === 'NO';
    }

    /**
     * @return mixed
     */
    public function getDefaultAttribute()
    {
        return $this->column_default;
    }

    /**
     * @return string
     */
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

    /**
     * @return Builder|Model|object|null
     */
    public function getForeignAttribute()
    {
        return PostgresqlConstraint::query()
            ->where([
                ['table_catalog', '=', $this->table_catalog],
                ['table_name', '=', $this->table_name],
                ['referencing_column_name', '=', $this->column_name],
            ])
            ->first();
    }
}
