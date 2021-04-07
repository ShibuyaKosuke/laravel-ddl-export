<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Database\Eloquent\Model;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ConstraintInterface;

class PostgresqlConstraint extends Model implements ConstraintInterface
{
    /**
     * @var string
     */
    protected $table = 'constraints';

    protected static function boot()
    {
        parent::boot();
    }
}