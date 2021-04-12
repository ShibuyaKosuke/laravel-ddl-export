<?php

namespace ShibuyaKosuke\LaravelDdlExport\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseProvider;
use ShibuyaKosuke\LaravelDdlExport\Console\DbUtilitiesCommand;
use ShibuyaKosuke\LaravelDdlExport\Models\Columns;
use ShibuyaKosuke\LaravelDdlExport\Models\CreateView;
use ShibuyaKosuke\LaravelDdlExport\Models\Repositories\MysqlManageView;
use ShibuyaKosuke\LaravelDdlExport\Models\Repositories\MysqlTable;
use ShibuyaKosuke\LaravelDdlExport\Models\Repositories\PostgresqlManageView;
use ShibuyaKosuke\LaravelDdlExport\Models\Repositories\PostgresqlTable;
use ShibuyaKosuke\LaravelDdlExport\Models\Table;

/**
 * Class ServiceProvider
 * @package ShibuyaKosuke\LaravelDdlExport\Providers
 */
class ServiceProvider extends BaseProvider
{
    public function boot()
    {
        $this->registerCommands();

        $tableRepository = null;

        $connection = Schema::getConnection();
        if ($connection->getDriverName() === 'pgsql') {
            $tableRepository = new PostgresqlTable();
            $constraintRepository = new PostgresqlManageView();
        } elseif ($connection->getDriverName() === 'mysql') {
            $tableRepository = new MysqlTable();
            $constraintRepository = new MysqlManageView();
        }

        $this->app->singleton('shibuyakosuke.table', function () use ($tableRepository) {
            return new Table($tableRepository);
        });

        $this->app->singleton('shibuyakosuke.constraints', function () use ($constraintRepository) {
            return new CreateView($constraintRepository);
        });

        $this->loadTranslationsFrom(__DIR__ . '/../../translations', 'ddl');

        $this->loadViewsFrom(__DIR__ . '/../../views', 'ddl');

        $this->publishes([
            __DIR__ . '/../../translations' => resource_path('lang/vendor/ddl'),
        ]);
    }

    protected function registerCommands()
    {

        $this->app->singleton('command.shibuyakosuke.db.utilities', static function ($app) {
            return new DbUtilitiesCommand();
        });

        $this->commands([
            'command.shibuyakosuke.db.utilities',
        ]);
    }

    public function provides()
    {
        return [
            'command.shibuyakosuke.db.utilities',
        ];
    }
}