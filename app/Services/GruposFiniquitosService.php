<?php

namespace App\Services;

use App\Models\Finiquito;
use App\Models\GrupoFiniquito;
use App\Models\Usuario;
use Illuminate\Support\Facades\DB;

class GruposFiniquitosService
{
    public function create($usuarioId, $fechaFiniquito, $zonaLabor, $ruta, $codigoBus)
    {
        $grupo = new GrupoFiniquito();
        $grupo->usuario_id = $usuarioId;
        $grupo->fecha_finiquito = $fechaFiniquito;
        $grupo->zona_labor = $zonaLabor;
        $grupo->ruta = $ruta;
        $grupo->codigo_bus = $codigoBus;
        $grupo->save();

        return $grupo;
    }

    public function changeState($estadoId, $id)
    {
        $grupo = GrupoFiniquito::find($id);

        if ($grupo->setEstado($estadoId)) {
            return [
                'message' => 'Estado cambiando correctamente',
                'data' => $grupo
            ];
        } else {
            return [
                'message' => 'Algo salió mal',
                'error' => true,
                'data' => $grupo
            ];
        }
    }

    public function get($usuarioId)
    {
        $rol = (Usuario::find($usuarioId))->getRol('finiquitos');

        switch ($rol->name) {
            case 'ANALISTA DE GESTION':
                $grupos = GrupoFiniquito::with('usuario')
                    ->where('usuario_id', $usuarioId)
                    ->orderBy('created_at', 'DESC')
                    ->get();
                break;

            default:
                $grupos = GrupoFiniquito::with('usuario')
                    ->orderBy('created_at', 'DESC')
                    ->get();
                break;
        }


        $grupos->transform(function($item) {
            $item->estado = $item->getEstado();
            $item->cantidad_registros = Finiquito::where('grupo_finiquito_id', $item->id)->count();

            return $item;
        });

        return $grupos;
    }

    public function find($id)
    {
        $grupo = GrupoFiniquito::with('usuario.trabajador')->where('id', $id)->first();

        $finiquitos = Finiquito::with('persona', 'empresa', 'tipoCese', 'regimen', 'oficio')
            ->where('grupo_finiquito_id', $grupo->id)
            ->orderBy('regimen_id', 'ASC')
            ->get();

        $finiquitos->transform(function($item) {
            $item->estado = $item->getEstado();
            return $item;
        });

        $grupo->estado = $grupo->getEstado();
        $grupo->finiquitos = $finiquitos;

        return $grupo;
    }
}
