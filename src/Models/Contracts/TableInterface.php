<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Interface TableInterface
 * @package ShibuyaKosuk\LaravelDdlExport\Models\Contracts
 * @extends \Illuminate\Database\Eloquent\Model
 */
interface TableInterface
{
    public function getNameAttribute(): string;

    public function getCommentAttribute(): string;

    public function columns(): HasMany;
}