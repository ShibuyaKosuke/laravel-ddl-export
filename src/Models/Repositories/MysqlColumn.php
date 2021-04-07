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

    public function table(): Table
    {
        return $this->TABLE_NAME;
    }

    public function getIsPrimaryKeyAttribute(): bool
    {
        return $this->primaryKey === $this->COLUMN_NAME;
    }

    public function getIsUniqueAttribute(): bool
    {
        return $this->COLUMN_KEY === 'UNI';
    }

    public function getNameAttribute(): string
    {
        return $this->COLUMN_NAME;
    }

    public function getTypeAttribute(): string
    {
        return $this->COLUMN_TYPE;
    }

    public function getLengthAttribute(): ?int
    {
        return $this->CHARACTER_MAXIMUM_LENGTH;
    }

    public function getNullableAttribute(): bool
    {
        return $this->IS_NULLABLE === 'YES';
    }

    public function getNotNullAttribute(): bool
    {
        return $this->IS_NULLABLE === 'NO';
    }

    public function getDefaultAttribute()
    {
        return $this->COLUMN_DEFAULT;
    }

    public function getCommentAttribute(): string
    {
        return $this->COLUMN_COMMENT;
    }
}