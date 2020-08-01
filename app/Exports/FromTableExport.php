<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class FromTableExport implements FromArray, WithColumnFormatting
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
    }

    public function columnFormats(): array
    {
        return [
            'B' => '#0'
        ];
    }
}
