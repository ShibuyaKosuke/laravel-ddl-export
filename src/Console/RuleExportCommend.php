<?php

namespace ShibuyaKosuke\LaravelDdlExport\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use ShibuyaKosuke\LaravelDdlExport\Facades\CreateView;
use ShibuyaKosuke\LaravelDdlExport\Facades\Table;
use ShibuyaKosuke\LaravelDdlExport\Facades\Type;
use ShibuyaKosuke\LaravelDdlExport\Helpers\Arr;
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
                    ->mapWithKeys(static function (ColumnInterface $column) {
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
                        return [$column->name => $rules];
                    })
            ];
        })->toArray();

        CreateView::down();

        File::put(
            config_path('rules.php'),
            sprintf("<?php\n\nreturn %s;\n", Arr::export($response))
        );
    }
}
