<?php

namespace ShibuyaKosuke\LaravelDdlExport\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider as BaseProvider;
use ShibuyaKosuke\LaravelDdlExport\Console\DbUtilitiesCommand;
use ShibuyaKosuke\LaravelDdlExport\Console\RuleExportCommend;
use ShibuyaKosuke\LaravelDdlExport\Console\TransExportCommend;
use ShibuyaKosuke\LaravelDdlExport\Models\CreateView;
use ShibuyaKosuke\LaravelDdlExport\Models\Repositories\MysqlManageView;
use ShibuyaKosuke\LaravelDdlExport\Models\Repositories\MysqlTable;
use ShibuyaKosuke\LaravelDdlExport\Models\Repositories\MysqlType;
use ShibuyaKosuke\LaravelDdlExport\Models\Repositories\PostgresqlManageView;
use ShibuyaKosuke\LaravelDdlExport\Models\Repositories\PostgresqlTable;
use ShibuyaKosuke\LaravelDdlExport\Models\Repositories\PostgresqlType;
use ShibuyaKosuke\LaravelDdlExport\Models\Table;
use ShibuyaKosuke\LaravelDdlExport\Models\Type;

/**
 * Class ServiceProvider
 * @package ShibuyaKosuke\LaravelDdlExport\Providers
 */
class ServiceProvider extends BaseProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->registerCommands();

        $tableRepository = null;
        $constraintRepository = null;
        $typeRepository = null;

        $connection = Schema::getConnection();
        if ($connection->getDriverName() === 'pgsql') {
            $tableRepository = new PostgresqlTable();
            $constraintRepository = new PostgresqlManageView();
            $typeRepository = new PostgresqlType();
        } elseif ($connection->getDriverName() === 'mysql') {
            $tableRepository = new MysqlTable();
            $constraintRepository = new MysqlManageView();
            $typeRepository = new MysqlType();
        }

        $this->app->singleton('shibuyakosuke.table', function () use ($tableRepository) {
            return new Table($tableRepository);
        });

        $this->app->singleton('shibuyakosuke.constraints', function () use ($constraintRepository) {
            return new CreateView($constraintRepository);
        });

        $this->app->singleton('shibuyakosuke.types', function () use ($typeRepository) {
            return new Type($typeRepository);
        });

        $this->loadTranslationsFrom(__DIR__ . '/../../translations', 'ddl');

        $this->loadViewsFrom(__DIR__ . '/../../views', 'ddl');

        $this->publishes([
            __DIR__ . '/../../translations' => resource_path('lang/vendor/ddl'),
        ]);
    }

    /**
     * @return void
     */
    protected function registerCommands(): void
    {
        $this->app->singleton('command.shibuyakosuke.db.utilities', static function ($app) {
            return new DbUtilitiesCommand();
        });
        $this->app->singleton('command.shibuyakosuke.db.translation', static function ($app) {
            return new TransExportCommend();
        });
        $this->app->singleton('command.shibuyakosuke.db.rules', static function ($app) {
            return new RuleExportCommend();
        });

        $this->commands([
            'command.shibuyakosuke.db.utilities',
            'command.shibuyakosuke.db.translation',
            'command.shibuyakosuke.db.rules',
        ]);
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return [
            'command.shibuyakosuke.db.utilities',
            'command.shibuyakosuke.db.translation',
            'command.shibuyakosuke.db.rules',
        ];
    }
}