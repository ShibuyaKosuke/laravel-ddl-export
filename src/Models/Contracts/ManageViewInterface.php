<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Contracts;

/**
 * Interface ManageViewInterface
 * @package ShibuyaKosuke\LaravelDdlExport\Models\Contracts
 */
interface ManageViewInterface
{
    /**
     * @return mixed
     */
    public function up();

    /**
     * @return mixed
     */
    public function down();
}