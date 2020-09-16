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

    public function getByTrabajador($rut)
    {
        $liquidaciones = Liquidaciones::getByTrabajador($rut);

        return response()->json($liquidaciones);
    }

    public function getPagados(Request $request)
    {
        $empresa_id = $request->query('empresa_id');
        $fecha_pago = $request->query('fecha_pago');
        $rut = $request->query('rut');

        $result = Liquidaciones::getPagados($empresa_id, $fecha_pago, $rut);

        return response()->json($result);
    }

    public function getRechazados(Request $request)
    {
        $empresa_id = $request->query('empresa_id');
        $result = Liquidaciones::getRechazados($empresa_id);

        return response()->json($result);
    }

    public function toggleRechazo($tipo, Request $request)
    {
        $finiquitos = $request->get('finiquitos');

        $result = Liquidaciones::toggleRechazo($tipo, $finiquitos);
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
                                'rut' => $line['DNI'],
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
                            'rut' => $line['DNI'],
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

    public function marcarPagadoMasivo(Request $request)
    {
        $data = $request->get('data');

        $result = Liquidaciones::marcarPagadoMasivo($data);

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

    public function terminarProceso(Request $request)
    {
        $finiquitos = $request->get('liquidaciones');
        $result = Liquidaciones::terminarProceso($finiquitos);

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

    public function montosPorEstado(Request $request)
    {
        $result = Liquidaciones::montosPorEstado($request->query('empresa_id'));

        return response()->json($result);
    }

    public function montosPorEstadoPorAnio($empresa_id)
    {
        $result = Liquidaciones::montosPorEstadoPorAnio($empresa_id);

        return response()->json($result);
    }

    public function cantidadPagosPorDia($empresa_id, Request $request)
    {
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');
        $result = Liquidaciones::cantidadPagosPorDia($empresa_id, $desde, $hasta);

        return response()->json($result);
    }
}
