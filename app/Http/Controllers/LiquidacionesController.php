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

        $name = '/finiquitos/' . now()->unix() . '.' . $file->getClientOriginalExtension();

        if (!\Storage::disk('public')->put($name, \File::get($file))) {
            return response()->json(['message' => 'Error al guardar el archivo']);
        }

        try {
            (new FastExcel)
                ->import(storage_path('app/public') . $name, function($line) {
                    return Liquidaciones::updateOrCreate(
                        [
                            'id' => $line['IdLiquidacion']
                        ],
                        [
                            'finiquito_id' => $line['IdFiniquito'],
                            'rut' => $line['RutTrabajador'],
                            'ano' => $line['Ano'],
                            'mes' => $line['Mes'],
                            'monto' => $line['MontoAPagar'],
                            'empresa_id' => $line['IdEmpresa']
                        ]
                    );
                });
            return true;
        } catch (\Execption $e) {
            return false;
        }
    }
}
