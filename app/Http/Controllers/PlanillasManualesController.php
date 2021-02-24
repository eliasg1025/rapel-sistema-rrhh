<?php

namespace App\Http\Controllers;

use App\Models\PlanillaManual;
use Illuminate\Http\Request;

class PlanillasManualesController extends Controller
{
    public function get(Request $request)
    {
        $tipoEntidad = $request->get('tipo');
        $empresaId = $request->get('empresa_id');

        $planillas = PlanillaManual::with('trabajador', 'usuario.trabajador')->where([
            'tipo_entidad' => $tipoEntidad,
            'empresa_id' => $empresaId,
        ])->get();

        return response()->json([
            'message' => 'Data obtenida correctamente',
            'data' => $planillas,
        ]);
    }

    public function update(PlanillaManual $planilla, Request $request)
    {
        try {
            $planilla->fecha_inicio = $request->get('fecha_inicio');
            $planilla->fecha_fin = $request->get('fecha_fin');
            $planilla->horas = $request->get('horas');

            $planilla->save();

            return response()->json([
                'message' => 'Registro actualizado correctamente',
                'data' => $planilla
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar el registro',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 400);
        }
    }
}
