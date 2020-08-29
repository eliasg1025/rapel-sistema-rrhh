<?php

namespace App\Http\Controllers;

use App\Exports\TrabajadoresObservadosExport;
use App\Services\ReniecService;
use App\Models\{Contrato, Empresa, Trabajador};
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{
    public function create(Request $request)
    {
        $is_save = Trabajador::_save($request->all());

        if ($is_save) {
            return response()->json([
                'message' => 'Trabajador creado correctamente'
            ], 201);
        } else {
            return response()->json([
                'message' => 'No se creo trabajador'
            ], 400);
        }
    }

    public function get(Request $request)
    {
        $filtro = $request->all();

        $trabajadores = Trabajador::_get($filtro);
        $cantidad = sizeof($trabajadores);

        return response()->json([
            'message' => $cantidad !== 1 ? "{$cantidad} coincidencias encontradas" : "{$cantidad} coincidencia encontrada",
            'data' => $trabajadores
        ], 200);
    }

    public function sctr(Request $request)
    {
        $sctr = Trabajador::sctr($request->all());

        return response()->json([
            'sctr' => $sctr
        ]);
    }

    public function getObservados(Request $request)
    {
        $filtro = $request->all();

        $trabajadores = Trabajador::_getObservados($filtro);
        return response()->json([
            'data' => $trabajadores
        ]);
    }

    public function getHorarios($rut)
    {
        $trabajador = Trabajador::where('rut', $rut)->first();

        if ($trabajador) {
            return response()->json([
                'horario_entrada' => $trabajador->horario_entrada,
                'horario_salida'  => $trabajador->horario_salida
            ]);
        } else {
            return response()->json([
                'horario_entrada' => '',
                'horario_salida'  => ''
            ]);
        }
    }

    public function revision(Request $request)
    {
        $result = Trabajador::revision($request->trabajadores);
        return response()->json($result);
    }

    public function obtencionReniecMasiva(Request $request)
    {
        $result = Trabajador::obtencionReniecMasiva($request->all());
        return response()->json($result);
    }

    /*
    public function test($rut)
    {
        $result = (new ReniecService())->getPersona($rut);

        return response()->json($result);
    }*/

    public function habilitar($id)
    {
        try {
            $contrato = Contrato::findOrFail($id);
            $contrato->observado = false;
            if ($contrato->save()) {
                return response()->json([
                    'message' => 'Contrato habilitado'
                ]);
            }
        } catch (\Exception $e)  {
            return response()->json([
                'message' => 'Contrato no existe'
            ]);
        }
    }
}
