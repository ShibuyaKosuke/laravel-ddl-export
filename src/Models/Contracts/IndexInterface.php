<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Contracts;

interface IndexInterface
{
    public function isPrimary(): bool;

    public function isUnique(): bool;
}