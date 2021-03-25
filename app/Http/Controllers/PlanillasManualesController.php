<?php

namespace App\Http\Controllers;

use App\Http\Requests\PlanillaManualPost;
use App\Models\PlanillaManual;
use App\Models\Trabajador;
use App\Models\Usuario;
use App\Services\PlanillasManualesService;
use Illuminate\Http\Request;

class PlanillasManualesController extends Controller
{
    public PlanillasManualesService $planillasService;

    public function __construct()
    {
        $this->planillasService = new PlanillasManualesService();
    }

    public function get(Request $request)
    {
        $tipoEntidad = $request->get('tipo');
        $motivoId = $request->get('motivo_id');
        $empresaId = $request->get('empresa_id');
        $estado = $request->get('estado');
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $usuarioId = $request->get('usuario_id');
        $rut = $request->get('rut');

        $rol = (Usuario::find($usuarioId))->getRol('registro-fotochecks');

        $trabajador = Trabajador::where('rut', $rut)->first();

        $planillas = PlanillaManual::with('trabajador', 'usuario.trabajador', 'motivo', 'empresa')
            ->where([
                'estado' => $estado
            ])
            ->when($tipoEntidad, function($query) use ($tipoEntidad) {
                $query->where('tipo_entidad', $tipoEntidad);
            })
            ->when($empresaId, function($query) use ($empresaId) {
                $query->where('empresa_id', $empresaId);
            })
            ->when($motivoId, function($query) use ($motivoId) {
                $query->where('motivo_planilla_manual_id', $motivoId);
            })
            ->when($estado == 1, function($query) use ($desde, $hasta) {
                $query->whereBetween('fecha_planilla', [$desde, $hasta]);
            })
            ->when($rol->name === 'SUPERVISOR', function($query) use ($usuarioId) {
                $query->where('usuario_id', $usuarioId);
            })
            ->when(!is_null($trabajador), function($query) use ($trabajador) {
                $query->where('trabajador_id', $trabajador->id);
            })
            ->orderBy('fecha_planilla', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get();

        $planillas->transform(function($item) {
            return $item;
        });

        return response()->json([
            'message' => 'Data obtenida correctamente',
            'data' => $planillas,
        ]);
    }

    public function create(PlanillaManualPost $request)
    {
        try {
            $result = $this->planillasService->create(
                $request->trabajador,
                $request->regimen_id,
                $request->empresa_id,
                $request->zona_labor_id,
                $request->fecha_planilla,
                $request->hora_entrada,
                $request->hora_salida,
                $request->motivo_planilla_manual_id,
                $request->usuario_id
            );

            if (isset($result['error'])) {
                return response()->json([
                    'message' => $result['message']
                ], 400);
            }

            return response()->json([
                'message' => 'Registro ingresado correctamente',
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear registro',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 400);
        }
    }

    public function update(PlanillaManual $planilla, Request $request)
    {
        try {
            $rows = $request->get('fechas');

            if ($rows) {
                foreach ($rows as $row) {
                    $newPlanilla = $planilla->replicate();
                    $newPlanilla->fecha_planilla = $row['fecha_planilla'];
                    $newPlanilla->hora_entrada = $row['hora_entrada'];
                    $newPlanilla->hora_salida = $row['hora_salida'];
                    $newPlanilla->estado = 1;
                    $newPlanilla->save();
                }

                $planilla->delete();
            } else {
                $planilla->hora_entrada = $request->get('hora_entrada');
                $planilla->hora_salida = $request->get('hora_salida');
                $planilla->motivo_planilla_manual_id = $request->get('motivo_planilla_manual_id');
                $planilla->save();
            }

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
