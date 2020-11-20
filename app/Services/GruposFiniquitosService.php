<?php

namespace App\Services;

use App\Models\GrupoFiniquito;

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

    public function get($usuarioId)
    {
        $grupos = GrupoFiniquito::with('usuario')
            ->where('usuario_id', $usuarioId)
            ->orderBy('created_at', 'DESC')
            ->get();

        return $grupos;
    }
}
