<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Contracts;

use ShibuyaKosuke\LaravelDdlExport\Models\Table;

/**
 * Interface ColumnInterface
 * @package ShibuyaKosuk\LaravelDdlExport\Models\Contracts
 */
interface ColumnInterface
{
    public function table(): Table;

    public function getIsPrimaryKeyAttribute(): bool;

    public function getIsUniqueAttribute(): bool;

    public function getNameAttribute(): string;

    public function getTypeAttribute(): string;

    public function getLengthAttribute(): ?int;

    public function getNullableAttribute(): bool;

    public function getNotNullAttribute(): bool;

    public function getDefaultAttribute();

    public function getCommentAttribute(): string;
}