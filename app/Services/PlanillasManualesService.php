<?php

namespace App\Services;

use App\Models\MotivoPlanillaManual;
use App\Models\PlanillaManual;
use App\Models\Trabajador;
use App\Models\ZonaLabor;

class PlanillasManualesService
{
    public function create(
        $trabajador,
        $regimenId,
        $empresaId,
        $zonaLaborId,
        $fechaPlanilla,
        $horaEntrada,
        $horaSalida,
        $motivoId,
        $usuarioId
    )
    {
        $trabajadorId = Trabajador::findOrCreate($trabajador);

        $zonaLabor = ZonaLabor::where([
            'code' => $zonaLaborId,
            'empresa_id' => $empresaId
        ])->first();

        $motivo = MotivoPlanillaManual::find($motivoId);

        $existeElMismoDia = PlanillaManual::where([
            'trabajador_id' => $trabajadorId,
        ])
            ->where('fecha_planilla', $fechaPlanilla)
            ->first();

        if ($existeElMismoDia) {
            $nombreSolicitante = $existeElMismoDia->usuario->trabajador->apellido_paterno . ' ' . $existeElMismoDia->usuario->trabajador->apellido_materno . ' ' . $existeElMismoDia->usuario->trabajador->nombre;
            return [
                'error' => true,
                'message' => 'Ya existe un registros para ese día. Registrado por: ' . $nombreSolicitante . ' el ' . $existeElMismoDia->fecha_solicitud
            ];
        }

        if ($horaEntrada === null && $horaSalida === null) {
            return [
                'error' => true,
                'message' => 'Tiene que elegir al menos una hora de entrada o de salida'
            ];
        }

        $planilla = new PlanillaManual();
        $planilla->fecha_solicitud = now()->toDateString();
        $planilla->fecha_planilla = $fechaPlanilla;
        $planilla->hora_entrada = $horaEntrada;
        $planilla->hora_salida = $horaSalida;
        $planilla->estado = 1;
        $planilla->trabajador_id = $trabajadorId;
        $planilla->regimen_id = $regimenId;
        $planilla->zona_labor_id = $zonaLabor->id;
        $planilla->usuario_id = $usuarioId;
        $planilla->empresa_id = $empresaId;
        $planilla->motivo_planilla_manual_id = $motivoId;
        $planilla->save();

        return $planilla;
    }
}
