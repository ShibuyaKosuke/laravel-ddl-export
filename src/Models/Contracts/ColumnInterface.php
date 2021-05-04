<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Contracts;

use ShibuyaKosuke\LaravelDdlExport\Models\Table;

/**
 * Interface ColumnInterface
 * @package ShibuyaKosuk\LaravelDdlExport\Models\Contracts
 *
 * @property-read boolean is_primary_key
 * @property-read boolean is_unique
 * @property-read string name
 * @property-read string type
 * @property-read integer length
 * @property-read string default
 * @property-read string comment
 * @property-read boolean not_null
 * @property-read bool nullable
 * @property-read mixed foreign
 */
interface ColumnInterface
{
    /**
     * @return Table
     */
    public function table(): Table;

    /**
     * @return boolean
     */
    public function getIsPrimaryKeyAttribute(): bool;

    /**
     * @return boolean
     */
    public function getIsUniqueAttribute(): bool;

    /**
     * @return string
     */
    public function getNameAttribute(): string;

    /**
     * @return string
     */
    public function getTypeAttribute(): string;

    /**
     * @return integer|null
     */
    public function getLengthAttribute(): ?int;

    /**
     * @return boolean
     */
    public function getNullableAttribute(): bool;

    /**
     * @return boolean
     */
    public function getNotNullAttribute(): bool;

    /**
     * @return mixed
     */
    public function getDefaultAttribute();

    /**
     * @return string
     */
    public function getCommentAttribute(): string;

    /**
     * @return mixed
     */
    public function getForeignAttribute();
}
