<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Liquidaciones;
use App\Services\ArchivosAprobacionService;
use App\Services\ArchivosBancoService;
use Carbon\Carbon;
use DateTime;
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

    public function reprogramarParaPago(Request $request)
    {
        $finiquito_id = $request->get('id');
        $fecha_pago = $request->get('fecha_pago');

        $finiquito = Liquidaciones::where('id', $finiquito_id)->first();

        $finiquito->fecha_pago = $fecha_pago;
        $finiquito->save();

        return response()->json([
            'message' => 'Actualizado correctamente'
        ]);
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
        try {
            $file = $request->file('tu-recibo');
            $empresa_id = $request->get('empresa_id');
            $desde = $request->get('desde');
            $hasta = $request->get('hasta');

            $name = '/tu-recibo/' . now()->unix() . '.' . $file->getClientOriginalExtension();

            if (!\Storage::disk('public')->put($name, \File::get($file))) {
                return response()->json(['message' => 'Error al guardar el archivo'], 400);
            }

            $contents_arr = file(storage_path('app/public') . $name, FILE_IGNORE_NEW_LINES);

            function getMes($text) {
                switch ($text) {
                    case 'Ene':
                        return 1;
                    case 'Feb':
                        return 2;
                    case 'Mar':
                        return 3;
                    case 'Abr':
                        return 4;
                    case 'May':
                        return 5;
                    case 'Jun':
                        return 6;
                    case 'Jul':
                        return 7;
                    case 'Ago':
                        return 8;
                    case 'Set':
                        return 9;
                    case 'Oct':
                        return 10;
                    case 'Nov':
                        return 11;
                    case 'Dic':
                        return 12;
                }
            }

            $errores = [];

            $arr = [];

            foreach ($contents_arr as $key => $value) {
                $data = str_getcsv($value, "\t");

                foreach ($data as $k => $v) {
                    $data[$k] = mb_convert_encoding($v, 'UTF-8', 'UTF-8');
                }

                $contents_arr[$key] = $data;

                if (!is_numeric($data[0])) {
                    continue;
                }

                $fecha_desde = Carbon::parse($desde);
                $fecha_hasta = Carbon::parse($hasta);
                $fecha_firma = Carbon::createFromFormat('d/m/Y H:i', $data[12]);

                if ( !$fecha_firma->between($fecha_desde, $fecha_hasta) ) {
                    continue;
                }

                $nombre_archivo = explode('_', $data[4]);
                $periodo = explode('-', $data[1]);

                try {
                    $liquidacion = DB::table('liquidaciones')
                        ->where([
                            'rut' => $nombre_archivo[0],
                            'ano' => 2000 + $periodo[1],
                            'mes' => getMes($periodo[0]),
                            'empresa_id' => $empresa_id,
                            'estado' => 0
                        ])
                        ->first();

                    if ($liquidacion) {
                        array_push($arr, [
                            'id' => $liquidacion->id,
                            'fecha_firma' => $fecha_firma->toDateTimeString()
                        ]);
                    }

                } catch (\Exception $e) {
                    array_push($errores, [
                        'rut' => $nombre_archivo,
                        'error' => $e->getMessage() . ' -- ' . $e->getLine()
                    ]);
                }
            }

            return response()->json([
                'message' => 'Actualización completada',
                'liquidaciones' => $arr,
                'errores' => $errores
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al importar',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    public function insertarTuRecibo(Request $request)
    {
        $liquidaciones = $request->get('liquidaciones');

        $result = Liquidaciones::insertarTuRecibo($liquidaciones);

        return response()->json($result);
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

    public function getFechasPago()
    {
        $result = Liquidaciones::getFechas();

        return response()->json($result);
    }

    public function descargarArchivosAprobacion(Request $request)
    {
        $service = new ArchivosAprobacionService($request->get('fecha_pago'));

        $result = $service->generate();

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }

        return response()->download($result['ruta']);
    }

    public function test()
    {
        return response()->json(Liquidaciones::getResumenPorFechaPago('2020-09-18'));
    }
}
