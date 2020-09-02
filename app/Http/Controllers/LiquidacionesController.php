<?php

namespace App\Http\Controllers;

use App\Models\Liquidaciones;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                    return DB::table('liquidaciones')->updateOrInsert(
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
                'message' => 'Importación completada existosamente'
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

    public function importarTuRecibo(Request $request)
    {
        $file = $request->file('tu-recibo');
        $empresa_id = $request->get('empresa_id');

        $name = '/tu-recibo/' . now()->unix() . '.' . $file->getClientOriginalExtension();

        if (!\Storage::disk('public')->put($name, \File::get($file))) {
            return response()->json(['message' => 'Error al guardar el archivo'], 400);
        }

        $correctos = 0;
        $errores = [];

        try {
            (new FastExcel)
                ->import(storage_path('app/public') . $name, function($line) use ($empresa_id, $correctos, $errores) {
                    $text = explode('_', $line['Archivo']);
                    try {
                        return DB::table('liquidaciones')->updateOrInsert(
                            [
                                'rut' => $line['CUIL'],
                                'mes' => (int) trim($text[2]),
                                'ano' => (int) trim($text[1]),
                                'empresa_id' => $empresa_id
                            ],
                            [
                                'estado' => 1,
                                'fecha_hora_marca_firmado' => Carbon::parse($line['Fecha Firma'])
                            ]
                        );
                    } catch (\Exception $e) {
                        array_push($errores, [
                            'rut' => $line['CUIL'],
                            'error' => $e->getMessage() . ' -- ' . $e->getLine()
                        ]);
                        return false;
                    }
                });

            return response()->json([
                'message' => 'Actualización completada',
                'correctos' => $correctos,
                'errores' => $errores
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al importar',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function programarParaPago(Request $request)
    {
        $fecha = $request->get('fecha');
        $finiquitos = $request->get('finiquitos');
        $result = Liquidaciones::forPayment($fecha, $finiquitos);

        if ( isset($result['error']) ) {
            return response()->json([
                'message' => $result['error']
            ], 400);
        }

        return response()->json([
            'message' => 'Se actualizaron ' . $result . ' registros',
            'actualizados' => $result
        ]);
    }
}
