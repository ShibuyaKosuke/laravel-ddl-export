<?php

namespace ShibuyaKosuke\LaravelDdlExport\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use ShibuyaKosuke\LaravelDdlExport\Exports\Concerns\ExcelMacro;
use ShibuyaKosuke\LaravelDdlExport\Models\Contracts\TableInterface;

/**
 * Class TableExport
 * @package ShibuyaKosuke\LaravelDdlExport\Exports
 */
class TableExport implements FromView, WithTitle, WithEvents
{
    use ExcelMacro;

    /**
     * @var TableInterface
     */
    private $table;

    /**
     * Cell Border setting
     * @var array
     */
    private $border = [
        'outline' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
        'horizontal' => [
            'borderStyle' => Border::BORDER_THIN
        ],
        'vertical' => [
            'borderStyle' => Border::BORDER_DOTTED
        ],
    ];

    /**
     * Cell Background-color setting
     * @var array
     */
    private $fill = [
        'fillType' => Fill::FILL_SOLID,
        'color' => [
            'argb' => 'FFD3F9D8'
        ],
    ];

    /**
     * TableExport constructor.
     * @param TableInterface $table
     */
    public function __construct(TableInterface $table)
    {
        static::setMacro();
        $this->table = $table;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('ddl::table', ['table' => $this->table]);
    }

    /**
     * @param string $tag
     * @param mixed $columns
     * @param mixed $indexes
     * @param mixed $referencing
     * @param mixed $referenced
     * @return array
     */
    protected function getRanges(string $tag, $columns, $indexes, $referencing, $referenced)
    {
        switch ($tag) {
            case 'th':
                return [
                    [
                        'start' => ['column' => 1, 'row' => 2],
                        'end' => ['column' => 2, 'row' => 6]
                    ],
                    [
                        'start' => ['column' => 1, 'row' => 9],
                        'end' => ['column' => 7, 'row' => 9]
                    ],
                    [
                        'start' => ['column' => 1, 'row' => $columns->count() + 12],
                        'end' => ['column' => 7, 'row' => $columns->count() + 12]
                    ],
                    [
                        'start' => ['column' => 1, 'row' => $columns->count() + 15 + $indexes->count()],
                        'end' => ['column' => 7, 'row' => $columns->count() + 15 + $indexes->count()]
                    ],
                    [
                        'start' => ['column' => 1, 'row' => $columns->count() + 18 + $indexes->count() + $referencing->count()],
                        'end' => ['column' => 7, 'row' => $columns->count() + 18 + $indexes->count() + $referencing->count()]
                    ],
                ];
            case 'table':
                return [
                    [
                        'start' => ['column' => 1, 'row' => 2],
                        'end' => ['column' => 7, 'row' => 6]
                    ],
                    [
                        'start' => ['column' => 1, 'row' => 10],
                        'end' => ['column' => 7, 'row' => 9 + $columns->count()]
                    ],
                    [
                        'start' => ['column' => 1, 'row' => $columns->count() + 13],
                        'end' => ['column' => 7, 'row' => $columns->count() + $indexes->count() + 12]
                    ],
                    [
                        'start' => ['column' => 1, 'row' => $columns->count() + $indexes->count() + 16],
                        'end' => ['column' => 7, 'row' => $columns->count() + $indexes->count() + $referencing->count() + 15]
                    ],
                    [
                        'start' => ['column' => 1, 'row' => $columns->count() + 18 + $indexes->count() + $referencing->count()],
                        'end' => ['column' => 7, 'row' => $columns->count() + 18 + $indexes->count() + $referencing->count() + $referenced->count()]
                    ],
                ];
        }
    }

    /**
     * @return \Closure[]
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                foreach ($this->getRanges('th', $this->table->columns, $this->table->indexes, $this->table->referencing, $this->table->referenced) as $rangeByColAndRow) {
                    $event->sheet->styleCells(
                        $rangeByColAndRow,
                        [
                            'borders' => $this->border,
                            'fill' => $this->fill
                        ]
                    );
                }
                foreach ($this->getRanges('table', $this->table->columns, $this->table->indexes, $this->table->referencing, $this->table->referenced) as $rangeByColAndRow) {
                    $event->sheet->styleCells(
                        $rangeByColAndRow,
                        [
                            'borders' => $this->border,
                        ]
                    );
                }

                $event->sheet->setColWidth(1, 9);
                $event->sheet->setColWidth(2, 18);
                $event->sheet->setColWidth(3, 18);
                $event->sheet->setColWidth(4, 18);
                $event->sheet->setColWidth(5, 18);
                $event->sheet->setColWidth(6, 18);
                $event->sheet->setColWidth(7, 18);
                $event->sheet->setColWidth(8, 18);
            }
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->table->name;
    }
}
