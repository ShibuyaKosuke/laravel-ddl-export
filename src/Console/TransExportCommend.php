<?php

namespace ShibuyaKosuke\LaravelDdlExport\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ShibuyaKosuke\LaravelDdlExport\Facades\CreateView;
use ShibuyaKosuke\LaravelDdlExport\Facades\Table;
use ShibuyaKosuke\LaravelDdlExport\Helpers\Arr;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ColumnInterface;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\TableInterface;

/**
 * Class TransExportCommend
 *
 * @package ShibuyaKosuke\LaravelDdlExport\Console
 */
class TransExportCommend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddl:trans';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export translation file by Database.';

    /**
     * @return void
     */
    public function handle(): void
    {
        CreateView::up();

        $response = Table::all()->mapWithKeys(function (TableInterface $table) {
            return [
                $table->name => $table->columns
                    ->mapWithKeys(static function (ColumnInterface $column) {
                        return [$column->name => $column->comment];
                    })
            ];
        })->toArray();

        $tables = Table::all()->mapWithKeys(function (TableInterface $table) {
            return [$table->TABLE_NAME => $table->TABLE_COMMENT];
        })->toArray();

        CreateView::down();

        $locale = \App::getLocale();
        $dir = \App::langPath($locale);

        if (!file_exists($dir) && !mkdir($dir, true) && !is_dir($dir)) {
            throw new \RuntimeException(sprintf('Directory "%s" was not created', $dir));
        }
        $old = require($dir . '/columns.php');
        $response = array_merge($response, $old);

        File::put(
            $dir . '/columns.php',
            sprintf("<?php\n\nreturn %s;\n", Arr::export($response))
        );

        File::put(
            $dir . '/tables.php',
            sprintf("<?php\n\nreturn %s;\n", Arr::export($tables))
        );
    }
}
