<?php

namespace App\Http\Controllers;

use App\Models\PlanillaManual;
use App\Models\Usuario;
use Illuminate\Http\Request;

class PlanillasManualesController extends Controller
{
    public function get(Request $request)
    {
        $tipoEntidad = $request->get('tipo');
        $motivoId = $request->get('motivo_id');
        $empresaId = $request->get('empresa_id');
        $estado = $request->get('estado');
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $usuarioId = $request->get('usuario_id');

        $rol = (Usuario::find($usuarioId))->getRol('registro-fotochecks');

        $planillas = PlanillaManual::with('trabajador', 'usuario.trabajador')->where([
            'tipo_entidad' => $tipoEntidad,
            'empresa_id' => $empresaId,
            'estado' => $estado
        ])
        ->when($motivoId, function($query) use ($motivoId) {
            $query->where('motivo_planilla_manual_id', $motivoId);
        })
        ->when($estado == 1, function($query) use ($desde, $hasta) {
            $query->whereBetween('fecha_planilla', [$desde, $hasta]);
        })
        ->when($rol->name === 'SUPERVISOR', function($query) use ($usuarioId) {
            $query->where('usuario_id', $usuarioId);
        })
        ->orderBy('fecha_planilla', 'DESC')
        ->get();

        return response()->json([
            'message' => 'Data obtenida correctamente',
            'data' => $planillas,
        ]);
    }

    public function create(Request $request)
    {
        return response()->json([
            'data' => $request->all()
        ]);
    }

    public function update(PlanillaManual $planilla, Request $request)
    {
        try {
            $rows = $request->get('fechas');

            foreach ($rows as $row) {
                $newPlanilla = $planilla->replicate();
                $newPlanilla->fecha_planilla = $row['fecha_planilla'];
                $newPlanilla->hora_entrada = $row['hora_entrada'];
                $newPlanilla->hora_salida = $row['hora_salida'];
                $newPlanilla->estado = 1;
                $newPlanilla->save();
            }

            $planilla->delete();

            return response()->json([
                'message' => 'Registro actualizado correctamente',
                'data' => []
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

    public function delete(PlanillaManual $planilla)
    {
        $planilla->delete();

        return response()->json([
            'message' => 'Planilla borrada correctamente',
            'data' => []
        ]);
    }
}
