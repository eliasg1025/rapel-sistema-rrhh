<?php

namespace App\Http\Controllers;

use App\Models\Liquidaciones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class LiquidacionesController extends Controller
{
    public function importar(Request $request)
    {
        $file = $request->file('finiquitos');

        $name = '/finiquitos/' . now()->unix() . '.' . $file->getClientOriginalExtension();

        if (!\Storage::disk('public')->put($name, \File::get($file))) {
            return response()->json(['message' => 'Error al guardar el archivo'], 400);
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
                            'empresa_id' => $line['IdEmpresa'],
                            'fecha_emision' => date($line['FechaEmision'])
                        ]
                    );
                });
            return response()->json([
                'message' => 'Importacion completada existosamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al importar',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function get(Request $request)
    {
        $fechas = [
            'desde' => Carbon::parse($request->desde),
            'hasta' => Carbon::parse($request->hasta)->lastOfMonth()
        ];
        $estado = $request->estado;
        $empresa_id = $request->empresa_id;

        $result = Liquidaciones::get($fechas, $estado, $empresa_id);

        return response()->json($result);
    }
}
