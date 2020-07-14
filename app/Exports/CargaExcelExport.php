<?php


namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CargaExcelExport implements WithMultipleSheets
{
    use Exportable;

    protected $data_contrato;
    protected $data_ficha_trabajador;

    public function __construct(array $data_contrato, array $data_ficha_trabajador)
    {
        $this->data_contrato = $data_contrato;
        $this->data_ficha_trabajador = $data_ficha_trabajador;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new ContratosExport($this->data_contrato);
        $sheets[] = new FichaExport($this->data_ficha_trabajador);

        return $sheets;
    }
}
