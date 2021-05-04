<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Database\Eloquent\Model;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ConstraintInterface;

/**
 * Class PostgresqlConstraint
 * @package ShibuyaKosuke\LaravelDdlExport\Models\Repositories
 */
class PostgresqlConstraint extends Model implements ConstraintInterface
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
    }
}