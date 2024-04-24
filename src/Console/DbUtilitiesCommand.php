<?php

namespace ShibuyaKosuke\LaravelDdlExport\Console;

use Illuminate\Console\Command;
use ShibuyaKosuke\LaravelDdlExport\Exports\DdlExport;
use ShibuyaKosuke\LaravelDdlExport\Facades\CreateView;
use ShibuyaKosuke\LaravelDdlExport\Facades\Table;

/**
 * Class DbUtilitiesCommand
 * @package ShibuyaKosuke\LaravelDdlExport\Console
 */
class DbUtilitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddl:export {--output=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export DDL by Database.';

    /**
     * @return void
     */
    public function handle(): void
    {
        $output = $this->option('output') ?? 'ddl.xlsx';

        if (!\Str::endsWith($output, '.xlsx')) {
            $output .= '.xlsx';
        }

        CreateView::up();

        (new DdlExport($this->getOutput()))->store($output);

        $this->output->success('Output: ' . storage_path($output));

        CreateView::down();
    }
}
