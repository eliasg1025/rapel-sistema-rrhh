<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BonosActividadesSheet implements FromCollection, WithTitle, WithCustomStartCell, WithHeadings, WithStyles
{
    public Collection $actividades;
    public array $columnasActividades;

    public function __construct($actividades, $columnasActividades)
    {
        $this->actividades = $actividades;
        $this->columnasActividades = $columnasActividades;
    }

    public function title(): string
    {
        return 'Actividades';
    }

    public function startCell(): string
    {
        return 'A5';
    }

    public function headings(): array
    {
        $columnas = array_column($this->columnasActividades, 'title');
        return $columnas;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            5 => ['font' => ['bold' => true]],
        ];
    }

    public function collection()
    {
        $ordenColumnas = array_column($this->columnasActividades, 'dataIndex');

        return $this->actividades;
    }
}
