<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;

class TrabajadoresObservadosExport implements FromArray
{
    use Exportable;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
    * @return array
    */
    public function array(): array
    {
        $cabeceras = [
            'Empresa',
            'RUT',
            'Apellidos',
            'Nombre',
            'Fecha Ingreso',
            'Grupo',
            'Contrato Activo',
            'Alerta'
        ];

        return [
            $cabeceras,
            $this->data
        ];
    }
}
