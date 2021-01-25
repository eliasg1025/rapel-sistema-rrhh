<?php

namespace App\Services;

use App\Models\Finiquito;
use App\Models\GrupoFiniquito;
use App\Models\Usuario;
use App\Helpers\PdfUtils;
use App\Models\ZonaLabor;
use Illuminate\Support\Facades\DB;

class GruposFiniquitosService
{
    public FiniquitosService $finiquitosService;

    public function __construct()
    {
        $this->finiquitosService = new FiniquitosService();
    }

    public function create($usuarioId, $fechaFiniquito, $zonaLabor = null, $ruta, $codigoBus)
    {
        $grupo = new GrupoFiniquito();
        $grupo->usuario_id = $usuarioId;
        $grupo->fecha_finiquito = $fechaFiniquito;
        $grupo->ruta = $ruta;
        $grupo->codigo_bus = $codigoBus;

        if (!$zonaLabor) {
            $pivot = DB::table('usuarios_zonas')->where('usuario_id', $usuarioId)->first();
            $zonaLabor = ZonaLabor::find($pivot->zona_labor_id)->name;
        }
        $grupo->zona_labor = $zonaLabor;
        $grupo->save();

        return $grupo;
    }

    public function update($id, $usuarioId, $fechaFiniquito, $zonaLabor, $ruta, $codigoBus)
    {
        $grupo = GrupoFiniquito::find($id);
        $grupo->usuario_id = $usuarioId;
        $grupo->fecha_finiquito = $fechaFiniquito;
        $grupo->zona_labor = $zonaLabor;
        $grupo->ruta = $ruta;
        $grupo->codigo_bus = $codigoBus;
        $grupo->save();

        return $grupo;
    }

    public function changeState($estadoId, $id, $justificacion)
    {
        $grupo = GrupoFiniquito::find($id);
        $grupo->justificacion = $justificacion;
        $grupo->save();

        if ($grupo->setEstado($estadoId)) {

            $estado = $grupo->getEstado();

            switch ($estado->name) {
                case 'ANULADO':

                    $finiquitos = Finiquito::where('grupo_finiquito_id', $grupo->id)->get();

                    $finiquitos->transform(function($item) {
                        $item->setEstado(3);
                    });

                    break;
                default:
                    break;
            }

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
        $grupo = GrupoFiniquito::with('usuario.trabajador', 'importacionesFiniquitos')->where('id', $id)->first();

        $finiquitos = Finiquito::with('persona', 'empresa', 'tipoCese', 'regimen', 'oficio', 'usuario.trabajador')
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

    public function updateFiniquitos($id)
    {
        try {
            $grupo = GrupoFiniquito::findOrFail($id);

            $finiquitos = $grupo->finiquitos;

            foreach ($finiquitos as $finiquito) {
                $estado = $finiquito->getEstado()->name;
                if ($estado === 'SIN EFECTO' || $estado === 'FIRMADO') {
                    continue;
                }

                $finiquito->setEstado(2);
            }

            return [
                'message' => 'Estado actualizado correctamente'
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Error al actualizar estado',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ];
        }
    }

    public function print($id)
    {
        $generados = [];
        $errores = [];

        try {
            $grupo = GrupoFiniquito::find($id);
            $finiquitos = $grupo->finiquitos;

            foreach ($finiquitos as $finiquito) {
                if ($finiquito->getEstado()->name === 'SIN EFECTO') {
                    continue;
                }

                $result = $this->finiquitosService->print($finiquito);

                if ($result['error']) {
                    array_push($errores, [
                        'object' => $finiquito,
                        'error' => $result['error']
                    ]);
                } else {
                    array_push($generados, [
                        'object' => $finiquito,
                        'filename' => $result['filename']
                    ]);
                }
            }

            $name = 'GRUPO_' . $grupo->fecha_finiquito . '_' . $grupo->zona_labor . '_' . $grupo->ruta . '_' . $grupo->codigo_bus;
            $result = PdfUtils::unirPdfs('/cargas-finiquitos/' . $grupo->id, $name, $generados);

            if ($result['error']) {
                return [
                    'error' => $result['error']
                ];
            }

            return [
                'message' => 'Documentos generados',
                'data' => [
                    'file' => '/storage/cargas-finiquitos/' . $grupo->id . '/' . $name . '.pdf',
                    'generados' => $generados,
                    'errores' => $errores,
                ]
            ];
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }
}
