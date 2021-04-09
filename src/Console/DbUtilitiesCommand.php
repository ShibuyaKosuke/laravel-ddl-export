<?php

namespace ShibuyaKosuke\LaravelDdlExport\Console;

use Illuminate\Console\Command;
use ShibuyaKosuke\LaravelDdlExport\Exports\DdlExport;
use ShibuyaKosuke\LaravelDdlExport\Facades\CreateView;
use ShibuyaKosuke\LaravelDdlExport\Facades\Table;

class DbUtilitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ddl:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * @return void
     */
    public function handle(): void
    {
        CreateView::up();

        $tables = Table::all();

        (new DdlExport($this->getOutput(), $tables))->store('ddl.xlsx');

        CreateView::down();
    }
}