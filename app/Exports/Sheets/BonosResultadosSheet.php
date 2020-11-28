<?php

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class BonosResultadosSheet implements FromCollection, WithTitle
{
    public function __construct()
    {
        //
    }

    public function title(): string
    {
        return 'Resultados';
    }

    public function collection()
    {
        return new Collection([
            [1, 2],
            [3, 4]
        ]);
    }
}
