<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Interface TableInterface
 * @package ShibuyaKosuk\LaravelDdlExport\Models\Contracts
 * @extends \Illuminate\Database\Eloquent\Model
 *
 * @property-read string name
 * @property-read string comment
 * @property-read Collection|ColumnInterface[] columns
 * @property-read Collection|ColumnInterface[] indexes
 * @property-read Collection|ColumnInterface[] referencing
 * @property-read Collection|ColumnInterface[] referenced
 *
 */
interface TableInterface
{
    /**
     * @return string
     */
    public function getNameAttribute(): string;

    /**
     * @return string
     */
    public function getCommentAttribute(): string;

    /**
     * @return HasMany
     */
    public function columns(): HasMany;
}