<?php

namespace App\Exports;

use App\Exports\Sheets\BonosActividadesSheet;
use App\Exports\Sheets\BonosResultadosSheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BonosExport implements WithMultipleSheets
{
    use Exportable;

    public Collection $actividades;
    public array $columnasActividades;

    public function __construct($actividades, $columnasActividades)
    {
        $this->actividades = $actividades;
        $this->columnasActividades = $columnasActividades;
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new BonosActividadesSheet($this->actividades, $this->columnasActividades);
        $sheets[] = new BonosResultadosSheet();

        return $sheets;
    }
}
