<?php

namespace App\Http\Controllers\Sqlsrv;

use App\Http\Controllers\Controller;
use App\Models\SqlSrv\ActividadTrabajador;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ActividadTrabajadorController extends Controller
{
    public function ultima($rut)
    {
        $result = ActividadTrabajador::getUltimaByTrabajador($rut);

        if ($result['error']) {
            return response()->json($result, 400);
        }

        return response()->json([
            'message' => $result['message'],
            'data' => [$result['data']]
        ]);
    }

    public function importar(Request $request)
    {
        $file = $request->file('file');

        $data = (new FastExcel)->import($file->path(), function($line) {
            $result = ActividadTrabajador::getUltimaByTrabajador($line['RUT']);

            if (!$result['error']) {
                return $result['data'];
            }

            return null;
        });

        return response()->json([
            'message' => 'Funciona',
            'data' => $data
        ]);
    }
}
