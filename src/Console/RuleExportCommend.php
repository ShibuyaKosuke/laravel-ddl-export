<?php

namespace ShibuyaKosuke\LaravelDdlExport\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ShibuyaKosuke\LaravelDdlExport\Facades\CreateView;
use ShibuyaKosuke\LaravelDdlExport\Facades\Table;
use ShibuyaKosuke\LaravelDdlExport\Facades\Type;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ColumnInterface;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\ConstraintInterface;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\TableInterface;

/**
 * Class RuleExportCommend
 * @package ShibuyaKosuke\LaravelDdlExport\Console
 */
class RuleExportCommend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddl:rules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export validation rules by Database.';

    /**
     * @return void
     */
    public function handle(): void
    {
        CreateView::up();

        $response = Table::all()->mapWithKeys(function (TableInterface $table) {
            return [
                $table->name => $table->columns
                    ->map(static function (ColumnInterface $column) {
                        /** @var ConstraintInterface $constraint */
                        $foreign = ($constraint = $column->foreign) ?
                            sprintf(
                                'exists:%s,%s',
                                $constraint->referenced_table_name,
                                $constraint->referenced_column_name
                            ) : null;

                        $rules = [];
                        $rules[] = Type::convertType($column);
                        $rules[] = ($column->not_null) ? 'required' : 'nullable';

                        if ($column->length) {
                            $rules[] = 'max:' . $column->length;
                        }
                        if ($column->is_unique) {
                            $rules[] = 'unique';
                        }
                        if ($foreign) {
                            $rules[] = $foreign;
                        }
                        $rules = array_map(function ($item) {
                            return "'" . $item . "'";
                        }, $rules);
                        return [sprintf("'%s'", $column->name) . ' => [' . implode(', ', $rules) . '],'];
                    })
            ];
        })->toArray();

//        CreateView::down();

        $res = '[' . PHP_EOL;
        foreach ($response as $tableName => $columns) {
            $res .= "    '" . $tableName . '\' => [' . PHP_EOL;
            foreach ($columns as $column) {
                $res .= '        ' . $column[0] . PHP_EOL;
            }
            $res .= '    ],' . PHP_EOL;
        }
        $res .= ']';

        File::put(
            config_path('rules.php'),
            sprintf("<?php\n\nreturn %s;\n", $res)
        );
    }
}
