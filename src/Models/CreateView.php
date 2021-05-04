<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models;

use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ManageViewInterface;

/**
 * Class CreateView
 * @package ShibuyaKosuke\LaravelDdlExport\Models
 */
class CreateView
{
    /**
     * @var ManageViewInterface
     */
    private ManageViewInterface $repository;

    /**
     * Table constructor.
     * @param ManageViewInterface $repository
     */
    public function __construct(ManageViewInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return void
     */
    public function up()
    {
        $this->repository->up();
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->repository->down();
    }
}