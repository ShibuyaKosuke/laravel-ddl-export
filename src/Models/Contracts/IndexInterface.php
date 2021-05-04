<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Contracts;

/**
 * Interface IndexInterface
 * @package ShibuyaKosuke\LaravelDdlExport\Models\Contracts
 */
interface IndexInterface
{
    /**
     * @return boolean
     */
    public function isPrimary(): bool;

    /**
     * @return boolean
     */
    public function isUnique(): bool;
}
