<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class CuentasExport implements FromArray, WithColumnFormatting
{
    use Exportable;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
    * @return array
    */
    public function array(): array
    {
        $cabeceras = [
            'FECHA DE SOLICITUD',
            'DNI',
            'TRABAJADOR',
            'BANCO',
            'CUENTA',
            'EMPRESA',
            'SUBIDO POR',
            'APERTURA'
        ];
        return [
            $cabeceras,
            $this->data
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => '#0',
            'E' => '#0'
        ];
    }
}
