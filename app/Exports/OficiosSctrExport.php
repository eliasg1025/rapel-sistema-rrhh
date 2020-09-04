<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;

class OficiosSctrExport implements FromArray
{
    use Exportable;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return [
            [ 'Empresa', 'Oficio', 'Código' ],
            $this->data
        ];
    }
}
