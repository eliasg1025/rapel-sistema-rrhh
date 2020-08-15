<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class FormulariosPermisoExport implements FromArray, WithColumnFormatting
{
    use Exportable;

    public $data;
    public $cabeceras;

    public function __construct(array $cabeceras, array $data)
    {
        $this->cabeceras = $cabeceras;
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return [
            $this->cabeceras,
            $this->data
        ];
        /*
        $all =  [
            $this->cabeceras
        ];

        foreach ($this->data as $data) {
            array_push($all, [

            ]);
        }

        return [];*/
    }

    public function columnFormats(): array
    {
        return [
            'C' => '@',
            'F' => '@',
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'L' => NumberFormat::FORMAT_DATE_TIME3,
            'M' => NumberFormat::FORMAT_DATE_TIME3,
        ];
    }
}
