<?php

namespace ShibuyaKosuke\LaravelDdlExport\Exports\Concerns;

use Maatwebsite\Excel\Sheet as ExcelSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

trait ExcelMacro
{
    public static function setMacro()
    {
        /**
         * @see https://phpspreadsheet.readthedocs.io/en/latest/topics/recipes/#valid-array-keys-for-style-applyfromarray
         */
        ExcelSheet::macro('styleCells', function (ExcelSheet $sheet, array $rangeByColAndRow, array $style) {
            $cellRange = sprintf(
                '%s%d:%s%d',
                Coordinate::stringFromColumnIndex($rangeByColAndRow['start']['column']),
                $rangeByColAndRow['start']['row'],
                Coordinate::stringFromColumnIndex($rangeByColAndRow['end']['column']),
                $rangeByColAndRow['end']['row']
            );
            $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
        });

        /**
         * @see https://phpspreadsheet.readthedocs.io/en/latest/topics/recipes/#setting-a-columns-width
         */
        ExcelSheet::macro('setAutoSize', function (ExcelSheet $sheet, int $column) {
            $sheet->getDelegate()->getColumnDimensionByColumn($column)->setAutoSize(true);
        });

        /**
         * @see https://phpspreadsheet.readthedocs.io/en/latest/topics/recipes/#setting-a-columns-width
         */
        ExcelSheet::macro('setColWidth', function (ExcelSheet $sheet, int $column, float $width) {
            $sheet->getDelegate()->getColumnDimensionByColumn($column)->setWidth($width);
        });
    }
}