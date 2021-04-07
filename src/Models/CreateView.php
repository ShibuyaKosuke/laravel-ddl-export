<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models;

use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ManageViewInterface;

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

    public function up()
    {
        $this->repository->up();
    }

    public function down()
    {
        $this->repository->down();
    }
}