<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessStoreManyFinquitos;
use App\Models\DocumentoTuRecibo;
use App\Models\Empresa;
use App\Models\EstadoDocumentoTuRecibo;
use App\Models\Regimen;
use App\Models\SqlSrv\ZonaLabor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class DocumentosTuReciboController extends Controller
{
    public function getByTrabajador(Request $request, $rut)
    {
        $tipo_documento_turecibo_id = $request->query('tipo_documento_turecibo_id');

        $result = DocumentoTuRecibo::_getByTrabajador($tipo_documento_turecibo_id, $rut);
        return response()->json($result);
    }

    public function massive(Request $request)
    {
        $data = $request->get('data');
        $empresa_id = $request->get('empresa_id');
        $tipo_documento_turecibo_id = $request->get('tipo_documento_turecibo_id');
        $usuario_id = $request->get('usuario_id');

        /* ProcessStoreManyFinquitos::dispatch($usuario_id, $empresa_id, $tipo_documento_turecibo_id, $data);

        return response()->json([
            'message' => 'Proceso en cola'
        ]); */

        $result = DocumentoTuRecibo::massiveCreate($usuario_id, $empresa_id, $tipo_documento_turecibo_id, $data);

        return response()->json($result);
    }

    public function update($id, Request $request)
    {
        $result = DocumentoTuRecibo::where('id', $id)->update(
            $request->all()
        );

        return response()->json($result);
    }

    public function generateJson(Request $request)
    {
        try {
            $file = $request->file('file');
            $tipo_documento_id = $request->get('tipo_documento_turecibo_id');
            $empresa_id = $request->get('empresa_id');

            $name = '/documentos-turecibo/' . now()->unix() . '.' . $file->getClientOriginalExtension();

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

            foreach ($contents_arr as $key => $value) {
                $data = str_getcsv($value, "\t");

                // dd($data);

                try {
                    foreach ($data as $k => $v) {
                        $data[$k] = mb_convert_encoding($v, 'UTF-8', 'UTF-8');
                    }

                    $contents_arr[$key] = $data;

                    if (!is_numeric($data[0])) {
                        continue;
                    }

                    $nombre_archivo = explode('_', $data[4]);
                    $periodo = explode('-', $data[1]);
                    $apellidos = explode(' ', $data[5]);

                    $regimen_id = 0;
                    switch ($data[10]) {
                        case 'EMPLEADOS AGRARIOS':
                            $regimen_id = 1;
                            break;

                        case 'EMPLEADOS REGULARES':
                            $regimen_id = 2;
                            break;

                        case 'OBREROS':
                            $regimen_id = 3;
                            break;

                        case 'ADMINISTRATIVOS':
                            $regimen_id = 4;
                            break;
                    }

                    $contents_arr[$key] = [
                        'rut' => $nombre_archivo[0],
                        'ano' => 2000 + $periodo[1],
                        'mes' => getMes($periodo[0]),
                        'estado' => $data[3],
                        'apellido_paterno' => $apellidos[0],
                        'apellido_materno' => $apellidos[sizeof($apellidos) - 1],
                        'nombre' => $data[6],
                        'estado' => $data[3],
                        'fecha_carga' => $data[12],
                        'fecha_firma' => $data[13],
                        'regimen_id' => $regimen_id,
                        'zona_labor_id' => $regimen_id !== 3 ? ZonaLabor::getIdByTrabajador($nombre_archivo[0], $empresa_id) : null,
                    ];

                } catch (\Exception $e) {
                    return response()->json([
                        'message' => $e->getMessage() . ' -- ' . $e->getLine(),
                        'rut' => $data
                    ]);
                    continue;
                }
            }
            //var_dump($contents_arr);

            array_shift($contents_arr);
            return response()->json([
                'data' => $contents_arr,
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
        $tipo_documento_turecibo_id = $request->query('tipo_documento_turecibo_id');
        $empresa_id = $request->query('empresa_id');
        $regimen_id = $request->query('regimen_id');
        $zona_labor_id = $request->query('zona_labor_id');
        $estado = $request->query('estado');

        $result = DocumentoTuRecibo::_get($tipo_documento_turecibo_id, $estado, $empresa_id, $regimen_id, $zona_labor_id);

        return response()->json($result);
    }

    public function getCantidadFirmadosPorDia(Request $request)
    {
        $tipo_documento_turecibo_id = $request->query('tipo_documento_turecibo_id');
        $desde = $request->query('desde');
        $hasta = $request->query('hasta');

        $empresa_id = $request->query('empresa_id');
        $regimen_id = $request->query('regimen_id');
        $zona_labor_id = $request->query('zona_labor_id');
        $periodo = $request->query('periodo');

        $result = DocumentoTuRecibo::getCantidadFirmadosPorDia($tipo_documento_turecibo_id, $desde, $hasta, $empresa_id, $regimen_id, $zona_labor_id, $periodo);


        return response()->json($result);
    }

    public function getCantidadPorZonaLabor(Request $request)
    {
        $periodo = $request->query('periodo');
        $empresa_id = $request->query('empresa_id');

        $result = DocumentoTuRecibo::getCantidadPorZonaLabor($periodo, $empresa_id);

        return response()->json($result);
    }
}
