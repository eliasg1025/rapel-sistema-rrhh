<?php

namespace App\Http\Controllers;

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

    public function getObservados()
    {
        $trabajadores = Trabajador::_getObservados();
        return response()->json([
            'data' => $trabajadores
        ]);
    }

    public function revision(Request $request)
    {
        $result = Trabajador::revision($request->trabajadores);
        return response()->json($result);
    }

    public function test($rut)
    {
        $result = (new ReniecService())->getPersona($rut);

        return response()->json($result);
    }

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
