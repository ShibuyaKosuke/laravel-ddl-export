<?php

namespace ShibuyaKosuke\LaravelDdlExport\Exports;

use Illuminate\Console\OutputStyle;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\BeforeWriting;
use ShibuyaKosuke\LaravelDdlExport\Facades\Table;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\TableInterface;

/**
 * Class DdlExport
 * @package ShibuyaKosuke\LaravelDdlExport\Exports
 */
class DdlExport implements WithMultipleSheets, WithEvents
{
    use Exportable;

    /**
     * @var
     */
    private $output;

    /**
     * @var TableInterface[]
     */
    private $tables;

    /**
     * DdlExport constructor.
     * @param OutputStyle|null $output
     * @param Collection|TableInterface[] $tables
     */
    public function __construct(OutputStyle $output = null)
    {
        $this->output = $output;
        $this->tables = Table::all();
    }

    /**
     * @return \Closure[]
     */
    public function registerEvents(): array
    {
        return [
            BeforeExport::class => function (BeforeExport $event) {
                if ($this->output) {
                    $this->output->writeln('Exporting...');
                }
            },
            BeforeWriting::class => function (BeforeWriting $event) {
                if ($this->output) {
                    $this->output->writeln('Writing...');
                }
            },
        ];
    }

    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];

        // Table list
        $sheets[] = new ListExport($this->tables);

        foreach ($this->tables as $table) {
            $sheets[] = new TableExport($table);
        }

        return $sheets;
    }
}
