<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Liquidaciones;
use App\Services\ArchivosBancoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class LiquidacionesController extends Controller
{
    public function massiveCreate(Request $request)
    {
        $data = $request->get('data');

        $result = Liquidaciones::massiveCreate($data);

        return response()->json($result);
    }

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
                            'fecha_emision' => date($line['FechaEmision']),
                            'banco' => $line['Banco'],
                            'numero_cuenta' => $line['NumeroCuentaBancaria']
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
        $estado = $request->estado;
        $fechas = [
            'desde' => Carbon::parse($request->desde),
            'hasta' => $estado == 0 ? Carbon::parse($request->hasta)->lastOfMonth() : Carbon::parse($request->hasta)
        ];
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

    public function testExcel(Request $request)
    {
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load(storage_path('app/public') . '/archivos-banco/base/BCP.xlsm');
            $worksheet = $spreadsheet->getActiveSheet();

            $worksheet->getCell('D12')->setValue('72437334');
            $worksheet->getStyle('D12')->getNumberFormat()->setFormatCode('@');
            $worksheet->getCell('E12')->setValue('GUERE');
            $worksheet->getCell('F12')->setValue('CANCHUCAJA');
            $worksheet->getCell('G12')->setValue('ELIAS');

            /*
            $worksheet->getCell('D13')->setValue('02437334');
            $worksheet->getStyle('D13')->getNumberFormat()->setFormatCode('@');
            $worksheet->getCell('E13')->setValue('GUERE');
            $worksheet->getCell('F13')->setValue('CANCHUCAJA');
            $worksheet->getCell('G13')->setValue('ELIAS');*/

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsm');
            $writer->save(storage_path('app/public') . '/archivos-banco/generados/BCP.xlsm');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function generateArchivosBanco(Request $request)
    {
        $data = $request->get('data');

        $fecha_pago = $request->get('filtro')['desde'] === $request->get('filtro')['hasta'] ? $request->get('filtro')['desde'] : false;
        $empresa = Empresa::find($request->get('filtro')['empresa_id']);

        if (!$fecha_pago) {
            return response()->json([
                'message' => 'Solo se procesa 1 fecha de pago a la vez'
            ], 400);
        }

        $archivos_banco = new ArchivosBancoService('finiquitos', $empresa, $fecha_pago, $data);

        $result = [
            'bcp' => $archivos_banco->archivosBcp(),
            'banbif' => $archivos_banco->archivosBanbif(),
            'scotiabank' => $archivos_banco->archivosScotiabank(),
            'bbva' => $archivos_banco->archivosBbva(),
            'interbank' => $archivos_banco->archivosInterbank()
        ];

        return response()->json($result);
    }
}
