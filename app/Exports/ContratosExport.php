<?php

namespace App\Exports;

use App\Models\{Contrato};
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;

class ContratosExport implements FromArray
{
    use Exportable;

    protected $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function array(): array
    {
        return Contrato::_show($this->id);
    }
}
