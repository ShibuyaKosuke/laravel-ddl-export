<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\TableInterface;

/**
 * Class PostgresqlTable
 * @package ShibuyaKosuk\LaravelDdlExport\Models\Repositories
 * @extends Model
 */
class PostgresqlTable extends Model implements TableInterface
{
    /**
     * @var string
     */
    protected $table = 'information_schema.tables';

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
            $db = $connection->getName();
            $databaseName = $connection->getDatabaseName();

            $builder->when($db === 'pgsql', function (Builder $builder) use ($databaseName) {
                $builder->where([
                    ['table_schema', '=', 'public'],
                    ['table_catalog', '=', $databaseName]
                ]);
            })->when($db === 'mysql', function (Builder $builder) use ($databaseName) {
                $builder->where([
                    ['table_schema', '=', $databaseName],
                    ['table_catalog', '=', 'def']
                ]);
            })->where('table_type', 'BASE TABLE');
        });
    }

    /**
     * @return string
     */
    public function getNameAttribute(): string
    {
        return $this->table_name;
    }

    /**
     * @return string
     */
    public function getCommentAttribute(): string
    {
        $row = DB::table('pg_stat_user_tables')
            ->join('pg_description', 'pg_description.objoid', '=', 'pg_stat_user_tables.relid')
            ->where([
                ['pg_stat_user_tables.relname', '=', $this->table_name],
                ['pg_description.objsubid', '=', 0]
            ])
            ->first('description');

        return $row->description ?? '';
    }

    /**
     * @return HasMany
     */
    public function columns(): HasMany
    {
        return $this->hasMany(PostgresqlColumn::class, 'table_name', 'table_name')
            ->orderBy('ordinal_position', 'asc');
    }

    /**
     * @return HasMany
     */
    public function indexes(): HasMany
    {
        return $this->hasMany(PostgresqlIndex::class, 'table_name', 'table_name');
    }

    /**
     * @return HasMany
     */
    public function referencing(): HasMany
    {
        return $this->hasMany(PostgresqlConstraint::class, 'table_name', 'table_name');
    }

    /**
     * @return HasMany
     */
    public function referenced(): HasMany
    {
        return $this->hasMany(PostgresqlConstraint::class, 'referenced_table_name', 'table_name');
    }
}