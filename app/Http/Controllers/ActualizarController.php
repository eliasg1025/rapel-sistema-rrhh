<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Nacionalidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActualizarController extends Controller
{
    public function porEmpresa(Request $request)
    {
        $nacionalidades = $request->nacionalidades;
        $tipos_zonas = $request->tipo_zonas;
        $tipos_vias = $request->tipos_vias;
        $zonas_labor = $request->zonas_labor;

        try {
            for ($i = 0; $i < sizeof($nacionalidades); $i++) {

                $empresa = $nacionalidades[$i]['empresa_id'] === '9' ? 1 : 2;

                $doesntExist = Nacionalidad::where([
                    'code' => $nacionalidades[$i]['id'],
                    'empresa_id' => $empresa
                ])->doesntExist();

                if ($doesntExist) {
                    $nacionalidad = new Nacionalidad();
                    $nacionalidad->code = $nacionalidades[$i]['id'];
                    $nacionalidad->name = $nacionalidades[$i]['name'];
                    $nacionalidad->empresa_id = $empresa;

                    $nacionalidad->save();
                } else {
                    $nacionalidad = Nacionalidad::firstWhere([
                        'code' => $nacionalidades[$i]['id'],
                        'empresa_id' => $empresa,
                    ]);
                    $nacionalidad->name = $nacionalidades[$i]['name'];
                    $nacionalidad->empresa_id = $empresa;

                    $nacionalidad->save();
                }
            }

            /*
            for ($i = 0; $i < sizeof($tipos_vias); $i++) {
                if (DB::table('tipos_zonas')->where('id', $tipos_vias[$i]['id']->doesntExist())) {

                }
            }*/

            return response()->json([
                'message' => 'Actualizacion completada exitosamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function localidades(Request $request)
    {
        return response()->json($request->all());
    }
}
