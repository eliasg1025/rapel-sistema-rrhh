<?php

namespace App\Http\Controllers;

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
    public function getByTrabajador($rut)
    {
        $result = DocumentoTuRecibo::_getByTrabajador($rut);
        return response()->json($result);
    }

    public function massive(Request $request)
    {
        $data = $request->get('data');
        $empresa_id = $request->get('empresa_id');
        $tipo_documento_turecibo_id = $request->get('tipo_documento_turecibo_id');

        $result = DocumentoTuRecibo::massiveCreate($empresa_id, $tipo_documento_turecibo_id, $data);

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

            $correctos = 0;
            $errores = [];

            $contents_arr = file(storage_path('app/public') . $name, FILE_IGNORE_NEW_LINES);

            foreach ($contents_arr as $key => $value) {
                $data = str_getcsv($value, "\t");

                try {
                    foreach ($data as $k => $v) {
                        $data[$k] = mb_convert_encoding($v, 'UTF-8', 'UTF-8');
                    }

                    $contents_arr[$key] = $data;

                    if (!is_numeric($data[0])) {
                        continue;
                    }

                    $nombre_archivo = explode('_', $data[4]);
                    $mes = explode('.', $nombre_archivo[2]);
                    $apellidos = explode(' ', $data[5]);

                    $regimen_id = 0;
                    switch ($data[9]) {
                        case 'EMPLEADOS AGRARIOS':
                            $regimen_id = 1;
                            break;

                        case 'EMPLEADOS REGULARES':
                            $regimen_id = 2;
                            break;

                        case 'OBREROS':
                            $regimen_id = 3;
                            break;
                    }

                    $contents_arr[$key] = [
                        'rut' => $nombre_archivo[0],
                        'ano' => $nombre_archivo[1],
                        'mes' => (int) $mes[0],
                        'estado' => $data[3],
                        'apellido_paterno' => $apellidos[0],
                        'apellido_materno' => $apellidos[sizeof($apellidos) - 1],
                        'nombre' => $data[6],
                        'estado' => $data[3],
                        'fecha_carga' => $data[11],
                        'fecha_firma' => $data[12] === '' ? $data[12] : null,
                        'regimen_id' => $regimen_id,
                        'zona_labor_id' => $regimen_id === 1 ? ZonaLabor::getIdByTrabajador($nombre_archivo[0], $empresa_id) : null,
                    ];

                } catch (\Exception $e) {
                    return response()->json([
                        'message' => $e->getMessage() . ' -- ' . $e->getLine(),
                        'rut' => $data
                    ]);
                    continue;
                }
            }

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

        $result = DocumentoTuRecibo::_get($tipo_documento_turecibo_id);

        return response()->json($result);
    }
}
