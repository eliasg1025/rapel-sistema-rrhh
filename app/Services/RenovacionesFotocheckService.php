<?php

namespace App\Services;

use App\Models\MotivoFotocheck;
use App\Models\RenovacionFotocheck;
use App\Models\Trabajador;
use App\Models\ZonaLabor;

class RenovacionesFotocheckService
{
    public function __construct()
    {
        //
    }

    public function create(
        $trabajador,
        $fechaSolicitud,
        $observacion=null,
        $regimenId,
        $zonaLaborId,
        $empresaId,
        $motivoPeridaFotocheckId,
        $colorFotocheckId,
        $usuarioId
    )
    {
        $trabajadorId = Trabajador::findOrCreate($trabajador);

        $zonaLabor = ZonaLabor::where([
            'code' => $zonaLaborId,
            'empresa_id' => $empresaId
        ])->first();

        $motivo = MotivoFotocheck::find($motivoPeridaFotocheckId);

        // Verificar si ya existe el mismo dia
        $existeElMismoDia = RenovacionFotocheck::where([
                'trabajador_id' => $trabajadorId,
            ])
            ->whereBetween('fecha_solicitud', [now()->subDay()->toDateString(), now()->toDateString()])
            ->first();

        if ($existeElMismoDia) {
            $solicitante = $existeElMismoDia->usuario->trabajador;

            return [
                'error' => true,
                'message' => 'No se puede registrar a un trabajador dos veces en un periodo de 2 días. Registrado por: ' . $solicitante->nombre_completo . ' el ' . $existeElMismoDia->fecha_solicitud
            ];
        }

        $renovacion = new RenovacionFotocheck();
        $renovacion->fecha_solicitud = $fechaSolicitud;
        $renovacion->observacion = $observacion;
        $renovacion->regimen_id = $regimenId;
        $renovacion->zona_labor_id = $zonaLabor->id;
        $renovacion->empresa_id = $empresaId;
        $renovacion->motivo_perdida_fotocheck_id = $motivoPeridaFotocheckId;
        $renovacion->color_fotocheck_id = $colorFotocheckId;
        $renovacion->usuario_id = $usuarioId;
        $renovacion->trabajador_id = $trabajadorId;

        if ($motivo->costo > 0) {
            $renovacion->estado_documento = 0;
        }

        $renovacion->save();

        $renovacion->motivo;

        return $renovacion;
    }
}
