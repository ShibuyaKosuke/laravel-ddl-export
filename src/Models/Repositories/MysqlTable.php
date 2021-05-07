<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\TableInterface;

/**
 * Class MysqlTable
 * @package ShibuyaKosuk\LaravelDdlExport\Models\Repositories
 */
class MysqlTable extends Model implements TableInterface
{
    /**
     * @var string
     */
    protected $table = 'information_schema.tables';

    /**
     * @var string[]
     */
    protected $appends = [
        'name',
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
                ['TABLE_SCHEMA', '=', $databaseName],
                ['TABLE_CATALOG', '=', 'def']
            ])->where('TABLE_TYPE', 'BASE TABLE');
        });
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->TABLE_NAME;
    }

    /**
     * @return string
     */
    public function getCommentAttribute(): string
    {
        return $this->TABLE_COMMENT;
    }

    /**
     * @return HasMany
     */
    public function columns(): HasMany
    {
        return $this->hasMany(MysqlColumn::class, 'TABLE_NAME', 'TABLE_NAME')
            ->orderBy('ORDINAL_POSITION');
    }

    /**
     * @return HasMany
     */
    public function indexes(): HasMany
    {
        return $this->hasMany(MysqlIndex::class, 'TABLE_NAME', 'TABLE_NAME');
    }

    /**
     * @return HasMany
     */
    public function referencing(): HasMany
    {
        return $this->hasMany(MysqlConstraint::class, 'table_name', 'TABLE_NAME');
    }

    /**
     * @return HasMany
     */
    public function referenced(): HasMany
    {
        return $this->hasMany(MysqlConstraint::class, 'referenced_table_name', 'TABLE_NAME');
    }
}