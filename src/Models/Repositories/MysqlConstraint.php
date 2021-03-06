<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ConstraintInterface;

/**
 * Class MysqlConstraint
 * @package ShibuyaKosuke\LaravelDdlExport\Models\Repositories
 */
class MysqlConstraint extends Model implements ConstraintInterface
{
    /**
     * @var string
     */
    protected $table = 'constraints';

    /**
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('database', function (Builder $builder) {
            $connection = Schema::getConnection();
            $databaseName = $connection->getDatabaseName();
            $builder->where('table_catalog', '=', $databaseName);
        });
    }
}