<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Liquidaciones;
use App\Models\Pago;
use App\Models\SqlSrv\Trabajador;
use App\Models\TipoPago;
use App\Models\Utilidad;
use App\Services\ArchivosAprobacionService;
use App\Services\ArchivosBancoService;
use App\Services\ImportarPagosService;
use App\Services\TxtBancoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, File, Storage};


class PagosController extends Controller
{
    private function getPago($key)
    {
        [$id, $tipoPagoId] = explode("@", $key);

        $tipo_pago = TipoPago::find($tipoPagoId);

        return DB::table($tipo_pago->table)->where('id', $id);
    }

    public function update(string $id, Request $request)
    {
        try {
            $pago = $this->getPago($id);

            $fecha_pago = $request->get('fecha_pago');
            $estado = $request->get('estado');

            $updated = $pago->update([
                'fecha_pago' => isset($fecha_pago) ? Carbon::parse($fecha_pago) : null,
                'estado' => $estado,
            ]);

            if ( $updated ) {
                return response()->json([
                    'message' => 'Actualización completada correctamente'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ]);
        }

    }


    /**
     * Solo disponible para liquidaciones
     */
    public function massiveCreate(Request $request)
    {
        $data         = $request->get('data');
        $tipo_pago_id = $request->get('tipo_pago_id');

        switch ( $tipo_pago_id ) {
            case 1:
                $result = Liquidaciones::massiveCreate($data);
                break;
            case 2:
                $result = Liquidaciones::massiveCreate($data);
                break;
        }

        return response()->json($result);
    }

    public function reprogramarParaPago(Request $request)
    {
        $pago_id = $request->get('id');
        $tipo_pago_id = $request->get('tipo_pago_id');
        $fecha_pago = $request->get('fecha_pago');

        $pago = $tipo_pago_id === 1
            ? Liquidaciones::where('id', $pago_id)->first()
            : Utilidad::where('id', $pago_id)->first();

        $pago->fecha_pago = $fecha_pago;
        $pago->estado = 2;
        $pago->save();

        return response()->json([
            'message' => 'Actualizado correctamente'
        ]);
    }

    public function importar(Request $request)
    {
        $file = $request->file('finiquitos');
        $tipo_pago_id = $request->get('tipo_pago_id');

        $name = '/finiquitos/' . now()->unix() . '.' . $file->getClientOriginalExtension();

        if (!Storage::disk('public')->put($name, File::get($file))) {
            return response()->json(['message' => 'Error al guardar el archivo'], 400);
        }

        $service = new ImportarPagosService($name, $tipo_pago_id);
        $result = $service->execute();

        if ($result['error']) {
            return response()->json($result, 400);
        }

        return response()->json($result);
    }

    public function get(Request $request)
    {
        $estado = $request->estado;
        $fechas = [
            'desde' => Carbon::parse($request->desde),
            'hasta' => $estado == 0 ? Carbon::parse($request->hasta)->lastOfMonth() : Carbon::parse($request->hasta)
        ];
        $empresa_id = $request->empresa_id;
        $tipo_pago_id = $request->tipo_pago_id;

        switch ( $tipo_pago_id ) {
            case 1:
                $result = Liquidaciones::get($fechas, $estado, $empresa_id);
                break;
            case 2:
                $result = Utilidad::get($fechas, $estado, $empresa_id);
                break;
            default:
                $a = Liquidaciones::get($fechas, $estado, $empresa_id);
                $b = Utilidad::get($fechas, $estado, $empresa_id);

                $result = [ ...$b, ...$a ];
                break;
        }

        return response()->json($result);
    }
    public function getByTrabajador($rut)
    {
        $liquidaciones = Liquidaciones::getByTrabajador($rut);
        $utilidades = Utilidad::getByTrabajador($rut);

        $result = [ ...$utilidades, ...$liquidaciones ];

        return response()->json($result);
    }

    public function getPagados(Request $request)
    {
        $empresa_id = $request->query('empresa_id');
        $fecha_pago = $request->query('fecha_pago');
        $banco = $request->query('banco');

        $liquidaciones = Liquidaciones::getPagados($empresa_id, $fecha_pago, $banco);
        $utilidades = Utilidad::getPagados($empresa_id, $fecha_pago, $banco);

        return response()->json([ ...$utilidades, ...$liquidaciones ]);
    }

    public function getPagadosTabla(Request $request)
    {
        $empresa_id = $request->query('empresa_id');
        $fecha_pago = $request->query('fecha_pago');
        $banco = $request->query('banco');

        $liquidaciones = Liquidaciones::getPagadosTabla($empresa_id, $fecha_pago, $banco);
        $utilidades = Utilidad::getPagadosTabla($empresa_id, $fecha_pago, $banco);

        return response()->json([
            'liquidaciones' => $liquidaciones,
            'utilidades' => $utilidades
        ]);
    }

    public function getRechazados(Request $request)
    {
        $empresa_id = $request->query('empresa_id');
        $liquidaciones = Liquidaciones::getRechazados($empresa_id);
        $utilidades = Utilidad::getRechazados($empresa_id);

        return response()->json([ ...$utilidades, ...$liquidaciones ]);
    }

    public function toggleRechazo($tipo, Request $request)
    {
        $liquidaciones = $request->get('liquidaciones');
        $utilidades = $request->get('utilidades');

        $result = Liquidaciones::toggleRechazo($tipo, $liquidaciones);
        $result2 = Utilidad::toggleRechazo($tipo, $utilidades);

        return response()->json($result + $result2);
    }

    /**
     * Actualizacion de documentos firmados
     */
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
                $fecha_hasta = Carbon::parse($hasta)->addDay();
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
        $empresa_id = $request->get('empresa_id');
        $fecha_pago = $request->get('fecha_pago');

        $result = Liquidaciones::marcarPagadoMasivo($empresa_id, $fecha_pago);
        $result2 = Utilidad::marcarPagadoMasivo($empresa_id, $fecha_pago);

        if ( isset($result['error']) || isset($result2['error']) ) {
            return response()->json([
                'message' => '' . $result['error']
            ], 400);
        }

        $service = new ArchivosAprobacionService($fecha_pago); // TODO
        $generation = $service->generate();

        if ( isset($generation['error']) ) {
            return response()->json([
                'message' => $generation['error']
            ], 400);
        }

        return response()->json([
            'message' => 'Se actualizaron ' . ( $result + $result2 ) . ' registros en estado PAGADO. Se ha generado el FORMATO DE APROBACIÓN en la siguiente <a target="_blank" href="/storage/formato-aprobacion/generados/FORMATO-APROBACION-' . $fecha_pago . '">ruta</a>',
            'actualizados' => $result
        ]);
    }

    public function programarParaPago(Request $request)
    {
        $fecha = $request->get('fecha');
        $liquidaciones = $request->get('liquidaciones');
        $utilidades = $request->get('utilidades');

        $result = Liquidaciones::forPayment($fecha, $liquidaciones);
        $result2 = Utilidad::forPayment($fecha, $utilidades);

        if ( isset($result['error']) || isset($result2['error']) ) {
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

    public function validarArchivosBanco(Request $request)
    {
        $data = $request->get('data');

        $fecha_pago = $request->get('filtro')['desde'] === $request->get('filtro')['hasta'] ? $request->get('filtro')['desde'] : false;
        $empresa = Empresa::find(
            $request->get('filtro')['empresa_id']
        );

        if (!$fecha_pago) {
            return response()->json([
                'message' => 'Solo se procesa 1 fecha de pago a la vez'
            ], 400);
        }

        $archivosTxt = new TxtBancoService($empresa, $fecha_pago, $data);

        $result = [
            'bcp' => $archivosTxt->validar('bcp'),
            'banbif' => $archivosTxt->validar('banbif'),
            'scotiabank' => $archivosTxt->validar('scotiabank'),
            'bbva' => $archivosTxt->validar('bbva'),
            'interbank' => $archivosTxt->validar('interbank')
        ];

        return response()->json($result);
    }


    public function terminarProceso(Request $request)
    {
        $liquidaciones = $request->get('liquidaciones');
        $utilidades = $request->get('utilidades');

        $result = Liquidaciones::terminarProceso($liquidaciones);
        $result2 = Utilidad::terminarProceso($utilidades);

        if ( isset($result['error']) ) {
            return response()->json([
                'message' => $result['error']
            ], 400);
        }

        if ( isset($result2['error']) ) {
            return response()->json([
                'message' => $result2['error']
            ], 400);
        }

        return response()->json([
            'message' => 'Se actualizaron ' . ( $result + $result2 ) . ' registros',
            'actualizados' => $result + $result2
        ]);
    }

    public function montosPorEstado(Request $request)
    {
        $tipo_pago_id = $request->query('tipo_pago_id');

        switch ( $tipo_pago_id ) {
            case 1:
                $result = Liquidaciones::montosPorEstado(
                    $request->query('empresa_id'),
                );
                break;
            case 2:
                $result = Utilidad::montosPorEstado(
                    $request->query('empresa_id'),
                );
                break;
        }

        return response()->json($result);
    }

    public function montosPorEstadoPorAnio(Request $request, $empresa_id)
    {
        $tipo_pago_id = $request->query('tipo_pago_id');

        switch ( $tipo_pago_id ) {
            case 1:
                $result = Liquidaciones::montosPorEstadoPorAnio($empresa_id);
                break;
            case 2:
                $result = Utilidad::montosPorEstadoPorAnio($empresa_id);
                break;
        }

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
        $path = '/formato-aprobacion/generados';

        $directories = Storage::disk('public')->files($path);

        $directories = array_map(function($v) {
            $arr = explode("/", $v);
            $file = $arr[sizeof($arr) - 1];
            $exploded_str = explode("_", $file);
            return [
                'key' => $v,
                'fecha_pago' => explode(".", $exploded_str[1])[0],
                'link' => $v
            ];
        }, $directories);

        return response()->json($directories);
    }

    public function descargarArchivosAprobacion(Request $request)
    {
        /*
        $service = new ArchivosAprobacionService($request->get('fecha_pago'));

        $result = $service->generate();

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }*/

        $ruta = storage_path() . '/formato-aprobacion/generados/FORMATO-APROBACION-' . $request->get('fecha_pago') . '.xlsx';

        return response()->download($ruta);
    }

    public function sincronizarDatosUtilidades(Request $request)
    {
        $ruts = $request->get('ruts');

        $count = 0;
        foreach ($ruts as $rut) {
            $info = Trabajador::getInfoCuenta($rut);

            DB::table('utilidades')->where('rut', $rut)->update([
                'numero_cuenta' => $info->numero_cuenta,
                'banco' => $info->banco
            ]);

            $count++;
        }

        return response()->json($count);
    }

    public function test($fecha_pago)
    {
        return response()->json(Pago::getResumenPorFechaPago($fecha_pago));
    }
}
