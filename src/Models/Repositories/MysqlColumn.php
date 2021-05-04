<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ColumnInterface;
use ShibuyaKosuke\LaravelDdlExport\Models\Table;

/**
 * Class MysqlColumn
 * @package ShibuyaKosuk\LaravelDdlExport\Models\Repositories
 * @property-read Table TABLE_NAME
 * @property-read string COLUMN_NAME
 * @property-read string COLUMN_KEY
 * @property-read string COLUMN_TYPE
 * @property-read string CHARACTER_MAXIMUM_LENGTH
 * @property-read string IS_NULLABLE
 * @property-read string COLUMN_DEFAULT
 * @property-read string COLUMN_COMMENT
 * @property-read string table_catalog
 * @property-read string table_name
 * @property-read string column_name
 */
class MysqlColumn extends Model implements ColumnInterface
{
    /**
     * @var string
     */
    protected $table = 'information_schema.columns';

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
                ['table_schema', '=', $databaseName],
                ['table_catalog', '=', 'def']
            ]);
        });
    }

    /**
     * @return Table
     */
    public function table(): Table
    {
        return $this->TABLE_NAME;
    }

    /**
     * @return boolean
     */
    public function getIsPrimaryKeyAttribute(): bool
    {
        return $this->primaryKey === $this->COLUMN_NAME;
    }

    /**
     * @return boolean
     */
    public function getIsUniqueAttribute(): bool
    {
        return $this->COLUMN_KEY === 'UNI';
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->COLUMN_NAME;
    }

    /**
     * @return string
     */
    public function getTypeAttribute(): string
    {
        return $this->COLUMN_TYPE;
    }

    /**
     * @return integer|null
     */
    public function getLengthAttribute(): ?int
    {
        return $this->CHARACTER_MAXIMUM_LENGTH;
    }

    /**
     * @return boolean
     */
    public function getNullableAttribute(): bool
    {
        return $this->IS_NULLABLE === 'YES';
    }

    /**
     * @return boolean
     */
    public function getNotNullAttribute(): bool
    {
        return $this->IS_NULLABLE === 'NO';
    }

    /**
     * @return mixed
     */
    public function getDefaultAttribute()
    {
        return $this->COLUMN_DEFAULT;
    }

    /**
     * @return string
     */
    public function getCommentAttribute(): string
    {
        return $this->COLUMN_COMMENT;
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
