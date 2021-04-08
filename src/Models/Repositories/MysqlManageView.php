<?php

namespace ShibuyaKosuke\LaravelDdlExport\Models\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ManageViewInterface;

class MysqlManageView implements ManageViewInterface
{
    private $sql;

    public function __construct()
    {
        $this->sql = File::get(__DIR__. '/../../sql/mysql_create_view.sql');
    }

    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS constraints');
        DB::statement($this->sql);
    }

    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS constraints');
    }
}