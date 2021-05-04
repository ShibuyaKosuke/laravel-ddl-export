<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ManageViewInterface;

/**
 * Class MysqlManageView
 * @package ShibuyaKosuke\LaravelDdlExport\Models\Repositories
 */
class MysqlManageView implements ManageViewInterface
{
    /**
     * @var string
     */
    private $sql;

    /**
     * MysqlManageView constructor.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function __construct()
    {
        $this->sql = File::get(__DIR__ . '/../../sql/mysql_create_view.sql');
    }

    /**
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS constraints');
        DB::statement($this->sql);
    }

    /**
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS constraints');
    }
}
