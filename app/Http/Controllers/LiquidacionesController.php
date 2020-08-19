<?php

namespace App\Http\Controllers;

use App\Models\Liquidaciones;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class LiquidacionesController extends Controller
{
    public function importar(Request $request)
    {
        $file = $request->file('finiquitos');

        return \Storage::disk('public')->put('/finiquitos', $file);

        $liquidaciones = (new FastExcel)->configureCsv(';','#',',', 'gbk')->import($file, function($line) {
            return Liquidaciones::create([
                'id' => $line['IdLiquidacion'],
                'finiquito_id' => $line['IdFiniquito'],
                'rut' => $line['RutTrabajador'],
                'ano' => $line['Ano'],
                'mes' => $line['Mes'],
                'monto' => $line['MontoAPagar'],
                'empresa_id' => $line['IdEmpresa']
            ]);
        });
    }
}
