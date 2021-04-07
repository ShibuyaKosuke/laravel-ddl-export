<?php

namespace ShibuyaKosuke\LaravelDdlExport\Exports;

use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use ShibuyaKosuke\LaravelDdlExport\Exports\Concerns\ExcelMacro;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\TableInterface;

class ListExport implements FromCollection, WithTitle, WithHeadings, WithEvents
{
    use ExcelMacro;

    /**
     * @var TableInterface[]
     */
    private $tables;

    public function __construct($tables)
    {
        $this->tables = $tables;
    }

    public function collection()
    {
        return $this->tables->map(function (TableInterface $table) {
            return collect([
                'name' => $table->name,
                'comment' => $table->comment,
                'model' => ($table->comment) ? sprintf('App\Models\%s', Str::studly($table->name)) : ''
            ]);
        });
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setColWidth(1, 24);
                $event->sheet->setColWidth(2, 24);
                $event->sheet->setColWidth(3, 24);
            }
        ];
    }

    public function title(): string
    {
        return config('app.name');
    }

    public function headings(): array
    {
        return [
            '物理名',
            '論理名',
            'Model'
        ];
    }
}
