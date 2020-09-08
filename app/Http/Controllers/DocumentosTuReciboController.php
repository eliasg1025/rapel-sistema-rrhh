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
    public function importar(Request $request)
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

                try {
                    $data = str_getcsv($value, "\t");

                    foreach ($data as $k => $v) {
                        $data[$k] = mb_convert_encoding($v, 'UTF-8', 'UTF-8');
                    }

                    $contents_arr[$key] = $data;

                    $nombre_archivo = explode('_', $data[4]);
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
                        'mes' => $nombre_archivo[2],
                        'estado' => $data[3],
                        'apellido_paterno' => $apellidos[0],
                        'apellido_materno' => $apellidos[1],
                        'nombre' => $data[6],
                        'firmado' => $data[3],
                        'fecha_carga' => $data[11],
                        'fecha_firma' => $data[12],
                        'regimen_id' => $regimen_id,
                        'zona_labor_id' => ZonaLabor::getIdByTrabajador($nombre_archivo[0], $empresa_id),
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
            return response()->json($contents_arr);
            /*
            (new FastExcel)
                ->import(storage_path('app/public') . $name, function($line) use ($empresa_id, $tipo_documento_id, $correctos, $errores) {
                    $text = explode('_', $line['Archivo']);
                    $apellido = explode(' ', $line['Apellido']);
                    try {
                        $result = DB::table('documentos_turecibo')->updateOrInsert(
                            [
                                'rut' => (string) trim($text[0]),
                                'mes' => (int) trim($text[2]),
                                'ano' => (int) trim($text[1]),
                                'empresa_id' => $empresa_id,
                                'tipo_documento_turecibo_id' => $tipo_documento_id,
                            ],
                            [
                                'estado_documento_turecibo_id' => EstadoDocumentoTuRecibo::where('name', $line['Firmado'])->first()->id,
                                'apellido_paterno' => $apellido[0],
                                'apellido_materno' => $apellido[1],
                                'nombre' => $line['Nombre'],
                                'email' => $line['Mail'] !== '' ? $line['Mail'] : null,
                                'regimen_id' => Regimen::where('name', $line['Sector'])->first()->id,
                                'zona_labor_id' => ZonaLabor::searchByTrabajador(trim($text[0]), $empresa_id)->zona_labor,
                                'fecha_carga' => Carbon::parse($line['Fecha Carga']),
                                'fecha_firma' => Carbon::parse($line['Fecha Firma']),
                            ]
                        );

                        $correctos++;
                        return true;
                    } catch (\Exception $e) {
                        array_push($errores, [
                            'rut' => (string) trim($text[0]),
                            'error' => $e->getMessage() . ' -- ' . $e->getLine()
                        ]);
                        return false;
                    }
                });*/

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

    public function get(Request $request)
    {
        $tipo_documento_turecibo_id = $request->query('tipo_documento_turecibo_id');

        $result = DocumentoTuRecibo::_get($tipo_documento_turecibo_id);

        return response()->json($result);
    }
}
