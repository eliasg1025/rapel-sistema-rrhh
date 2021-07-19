<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SancionEpp extends Model
{
    protected $table = 'sanciones_epps';

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function trabajador()
    {
        return $this->belongsTo('App\Models\Trabajador');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario');
    }

    public function oficio()
    {
        return $this->belongsTo('App\Models\Oficio');
    }

    public function zona_labor()
    {
        return $this->belongsTo('App\Models\ZonaLabor');
    }

    public static function _get(int $usuario_id, array $fechas)
    {
        $usuario = Usuario::find($usuario_id);

        if (!$usuario) {
            return [
                'error' => true,
                'message' => 'No se encontro el usuario'
            ];
        }

        switch ($usuario->sanciones) {
            case 1:
            case 2:
                $data = DB::table('sanciones_epps as f')
                    ->select(
                        'f.id',
                        DB::raw('DATE_FORMAT(f.created_at, "%d/%m/%Y") fecha_solicitud'),
                        'f.observacion',
                        't.rut',
                        't.code',
                        DB::raw('CONCAT(t.apellido_paterno, " ", t.apellido_materno, " ", t.nombre) as nombre_completo'),
                        'z.code as zona_labor_id',
                        'z.name as zona_labor',
                        DB::raw('DATE_FORMAT(f.fecha_incidencia, "%d/%m/%Y") fecha_incidencia'),
                        'e.shortname as empresa',
                        're.name as regimen',
                        'o.name  as oficio',
                        'f.motivo',
                        'f.epps',
                        'f.contador',
                        'f.sancion_id'
                    )
                    ->join('trabajadores as t', 't.id', '=', 'f.trabajador_id')
                    ->join('empresas as e', 'e.id', '=', 'f.empresa_id')
                    ->join('zona_labores as z', 'z.id', '=', 'f.zona_labor_id')
                    ->leftJoin('regimenes as re', 're.id', '=', 'f.regimen_id')
                    ->join('oficios as o', 'o.id', '=', 'f.oficio_id')
                    ->whereBetween('f.fecha_incidencia', [$fechas['desde'], $fechas['hasta']])
                    ->when($usuario->sanciones !== 2, function($query) use ($usuario) {
                        $query->where('f.usuario_id', $usuario->id);
                    })
                    ->orderBy('f.created_at', 'DESC')
                    ->get();
                break;
            default:
                $data = [];
                break;
        }

        return $data;
    }

    public static function _create(array $data)
    {
        DB::beginTransaction();
        $message = '';
        try {
            $zona_labor_id     = ZonaLabor::findOrCreate($data['zona_labor']);
            $cuartel_id        = isset($data['cuartel']) ? Cuartel::findOrCreate($data['cuartel'], $zona_labor_id) : null;
            $trabajador_id     = Trabajador::findOrCreate($data['trabajador']);
            $regimen_id        = isset($data['regimen']) ? Regimen::findOrCreate($data['regimen']) : null;

            if (!isset($data['oficio'])) {
                DB::rollBack();
                return [
                    'rut' => $data['trabajador']['rut'],
                    'error' => 'Este trabajador no tiene un contrato activo'
                ];
            }

            $ofico_id = Oficio::findOrCreate($data['oficio']);

            /* $registro_mismo_dia = SancionEpp::where('trabajador_id', $trabajador_id)
                ->whereDate('fecha_incidencia', $data['fecha_incidencia'])
                ->first();

            if ($registro_mismo_dia) {
                DB::rollBack();
                return [
                    'rut' => $data['trabajador']['rut'],
                    'error' => 'Ya existe una sanción (EPP) por para el ' . $data['fecha_incidencia'] . '<br />USUARIO: ' . $registro_mismo_dia->usuario->trabajador->nombre_completo
                ];
            } */

            $sancion                        = new SancionEpp();
            $sancion->fecha_incidencia      = $data['fecha_incidencia'];
            $sancion->usuario_id            = $data['usuario_id'];
            $sancion->empresa_id            = $data['empresa_id'];
            $sancion->trabajador_id         = $trabajador_id;
            $sancion->regimen_id            = $regimen_id;
            $sancion->oficio_id             = $ofico_id;
            $sancion->zona_labor_id         = $zona_labor_id;
            $sancion->cuartel_id            = $cuartel_id;
            $sancion->motivo                = $data['motivo'];
            $data['motivo'] !== 'NO REPORTAR TRABAJADOR SIN EPP(s)' && $sancion->epps = json_encode($data['epps']);

            $contador = SancionEpp::where('trabajador_id', $trabajador_id)
                ->when($data['motivo'] === 'NO REPORTAR TRABAJADOR SIN EPP(s)', function($query) {
                    $query->where('motivo', 'NO REPORTAR TRABAJADOR SIN EPP(s)');
                })
                ->when($data['motivo'] !== 'NO REPORTAR TRABAJADOR SIN EPP(s)', function($query) {
                    $query->where('motivo', '<>', 'NO REPORTAR TRABAJADOR SIN EPP(s)');
                })
                ->count() + 1;

            $message .= 'Esta es la ' . $contador . ' incidencia';

            $sancion->contador = $contador;

            $info_sancion = [
                'generar'       => false,
                'tipo'          => null,
                'incidencia_id' => 0,
                'mensaje'       => ''
            ];

            if ($data['motivo'] !== 'NO REPORTAR TRABAJADOR SIN EPP(s)') {
                switch ($contador) {
                    case 4:
                    case 3:
                        $info_sancion['generar'] = true;
                        $info_sancion['tipo'] = 'SUSPENCION';
                        $info_sancion['incidencia_id'] = 19;
                        break;
                    case 5:
                        $info_sancion['generar'] = true;
                        $info_sancion['tipo'] = 'SUSPENCION';
                        $info_sancion['incidencia_id'] = null;
                        $info_sancion['mensaje'] = 'Evaluar cese del trabajador';
                        break;
                    default:
                        break;
                }
            } else {
                switch ($contador) {
                    case 1:
                    default:
                        $info_sancion['generar'] = true;
                        $info_sancion['tipo'] = 'MEMORANDUM';
                        $info_sancion['incidencia_id'] = 5;
                        break;
                }
            }

            if ($sancion->save()) {
                DB::commit();
                return [
                    'error'     => false,
                    'rut'       => $sancion->trabajador->rut,
                    'message'   => 'Sanción ' . (isset($data['id']) ? 'actualizada' : 'creada') . ' correctamente' . '<br />' . $message,
                    'id'        => $sancion->id,
                    'info_sancion' => $info_sancion,
                ];
            }

            DB::rollBack();
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }

    public static function _generarSancion($id, array $data)
    {
        DB::beginTransaction();
        try {
            $sancion = Sancion::_create($data);
            $sancionEpp = SancionEpp::find($id);
            if ($sancion['error']) {
                DB::rollBack();
                $sancionEpp->delete();
                return [
                    'error' => $sancion['error']
                ];
            }
            $sancionEpp->sancion_id = $sancion['id'];

            if ($sancionEpp->save()) {
                DB::commit();
                return [
                    'error'     => false,
                    'rut'       => $sancionEpp->trabajador->rut,
                    'message'   => 'Sanción ' . (isset($data['id']) ? 'actualizada' : 'creada') . ' correctamente',
                    'id'        => $sancionEpp->id
                ];
            }

            DB::rollBack();
            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }
}
