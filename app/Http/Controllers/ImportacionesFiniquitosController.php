<?php

namespace App\Http\Controllers;

use App\Models\ImportacionFiniquito;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ImportacionesFiniquitosController extends Controller
{
    public function export(ImportacionFiniquito $importacionFiniquito)
    {
        $registros = $importacionFiniquito->observaciones;

        return (new FastExcel($registros))->download($importacionFiniquito->name . '.xlsx', function ($registro) {
            return [
                'RUT' => $registro->rut,
                'OBSERVACIÓN' => $registro->descripcion,
            ];
        });
    }
}
