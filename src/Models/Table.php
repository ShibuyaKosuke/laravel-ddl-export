<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models;

use Illuminate\Support\Collection;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\TableInterface;

/**
 * Class Table
 * @package ShibuyaKosuk\LaravelDdlExport\Models
 */
class Table
{
    /**
     * @var TableInterface
     */
    private TableInterface $repository;

    /**
     * Table constructor.
     * @param TableInterface $repository
     */
    public function __construct(TableInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->repository->with(['columns', 'referencing', 'referenced', 'indexes'])->orderBy('table_name')->get();
    }

    /**
     * @param $columns
     * @return mixed
     */
    public function get($columns)
    {
        return $this->repository->with(['columns', 'referencing', 'referenced', 'indexes'])->get($columns);
    }

    /**
     * テーブル名を取得する
     *
     * @return string
     */
    public function name(): string
    {
        return $this->repository->name;
    }

    /**
     * テーブルコメントを取得する
     *
     * @return string
     */
    public function comment(): string
    {
        return $this->repository->comment;
    }
}