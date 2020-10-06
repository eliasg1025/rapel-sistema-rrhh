<?php

namespace App\Models;

use App\Helpers\DiasSancion;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sancion extends Model
{
    protected $table = 'sanciones';

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

    public function incidencia()
    {
        return $this->belongsTo('App\Models\Incidencia');
    }

    public function oficio()
    {
        return $this->belongsTo('App\Models\Oficio');
    }

    public function zona_labor()
    {
        return $this->belongsTo('App\Models\ZonaLabor');
    }

    public function getFechaIncidenciaLargoAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_incidencia);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }

    public function getFechaSalidaLargoAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_salida);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }

    public function getFechaRegresoLargoAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_regreso);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }

    public function getFechaReiLargoAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_regreso)->addDay();
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }

    public static function getDiasSancion($incio, int $cantidad_dias)
    {

    }

    public function getCorrelativo($fecha_incidencia)
    {
        $anio = Carbon::parse($fecha_incidencia)->format('Y');

        $ids = DB::table('sanciones as s')
            ->select('s.id as id')
            ->join('incidencias as i', 's.incidencia_id', '=', 'i.id')
            ->where('i.documento', 'MEMORANDUM')
            ->whereYear('s.fecha_solicitud', $anio)
            ->orderBy('s.id')
            ->get()->toArray();

        return array_search($this->id, array_column($ids, 'id')) + 1;
    }

    public static function _show($id)
    {
        $trabajadores = DB::table('trabajadores as t')
            ->select('t.id', 't.rut', DB::raw('CONCAT(t.apellido_paterno, " ", t.apellido_materno, " ", t.nombre) as nombre_completo'));

            return DB::table('sanciones as f')
            ->select(
                'f.id',
                'trabajador.rut',
                'f.fecha_solicitud',
                'f.empresa_id',
                'trabajador.nombre_completo as nombre_completo',
                'f.fecha_incidencia',
                'f.incidencia_id',
                'f.observacion',
                'z.code as zona_labor_id',
                'c.code as cuartel_id'
            )
            ->joinSub($trabajadores, 'trabajador', function($join) {
                $join->on('trabajador.id', 'f.trabajador_id');
            })
            ->join('zona_labores as z', 'z.id', '=', 'f.zona_labor_id')
            ->leftJoin('cuarteles as c', 'c.id', '=', 'f.cuartel_id')
            ->where('f.id', $id)
            ->first();
    }

    public static function _create(array $data)
    {
        DB::beginTransaction();
        $message = '';
        try {
            $incidencia        = Incidencia::find($data['incidencia_id']);
            $zona_labor_id     = ZonaLabor::findOrCreate($data['zona_labor']);
            $cuartel_id        = isset($data['cuartel']) ? Cuartel::findOrCreate($data['cuartel'], $zona_labor_id) : null;

            if ( !isset($data['id']) ) {
                $trabajador_id     = Trabajador::findOrCreate($data['trabajador']);
                $regimen_id        = isset($data['regimen']) ? Regimen::findOrCreate($data['regimen']) : null;

                if (!isset($data['oficio'])) {
                    DB::rollBack();
                    return [
                        'rut' => $data['trabajador']['rut'],
                        'error' => 'Este trabajador no tiene un contrato activo'
                    ];
                }
                $ofico_id          = Oficio::findOrCreate($data['oficio']);

                // TODO: Comentado temporalmente para pruebas
                $registro_mismo_dia = Sancion::where('trabajador_id', $trabajador_id)
                    ->whereDate('fecha_incidencia', $data['fecha_incidencia'])
                    ->where('incidencia_id', $data['incidencia_id'])
                    ->first();

                if ( $registro_mismo_dia ) {
                    DB::rollBack();
                    return [
                        'rut' => $data['trabajador']['rut'],
                        'error' => 'Ya existe una sanción por para el ' . $data['fecha_incidencia'] . '<br />USUARIO: ' . $registro_mismo_dia->usuario->trabajador->nombre_completo
                    ];
                }

                // Detecta si es que actualmente el trabajador esta suspendido
                $suspencion_actual = Sancion::where('trabajador_id', $trabajador_id)
                    ->where('fecha_salida', '<=', date($data['fecha_incidencia']))
                    ->where('fecha_regreso', '>=', date($data['fecha_incidencia']))
                    ->first();

                if ( $suspencion_actual ) {
                    DB::rollBack();
                    return [
                        'rut' => $data['trabajador']['rut'],
                        'error' => 'El trabajador se encuentra suspendido desde ' . $suspencion_actual['fecha_salida'] . ' hasta ' . $suspencion_actual['fecha_regreso']
                    ];
                }

                $sancion                  = new Sancion();
                $sancion->usuario_id      = $data['usuario_id'];
                $sancion->trabajador_id   = $trabajador_id;
                $sancion->regimen_id      = $regimen_id;
                $sancion->oficio_id       = $ofico_id;
                $sancion->fecha_solicitud = $data['fecha_solicitud'];
            } else {
                $sancion = Sancion::find($data['id']);
                $trabajador_id = $sancion->trabajador_id;
            }

            $sancion->zona_labor_id   = $zona_labor_id;
            $sancion->cuartel_id      = $cuartel_id;
            $sancion->fecha_incidencia = $data['fecha_incidencia'];
            $sancion->empresa_id         = $data['empresa_id'];
            $sancion->incidencia_id   = $data['incidencia_id'];

            if ( $incidencia->documento == 'SUSPENCION' ) {

                // Detectar si hay faltas reiterativas sobre la misma incidencia
                $rango_fechas = [
                    Carbon::parse($data['fecha_incidencia'])->subDays(90),
                    Carbon::parse($data['fecha_incidencia'])
                ];

                $suspencion = Sancion::where([
                    'trabajador_id' => $trabajador_id,
                    'incidencia_id' => $data['incidencia_id']
                ])->whereBetween('fecha_incidencia', $rango_fechas)
                    ->where('id', '<>', $sancion->id)
                    ->orderBy('fecha_incidencia', 'DESC')
                    ->first();

                $dias_suspencion = 0;
                //dd($suspencion);
                if (!$suspencion) {
                    $dias_suspencion = $incidencia->dias;
                } else {
                    if ($suspencion->reiterativo === 1) {
                        $dias_suspencion = $incidencia->dias_reiterativo;
                        $sancion->reiterativo = 2;
                        $message = 'Esta es una falta reiterativa se suspenderá por ' . $dias_suspencion . ' días.';
                    } else if ($suspencion->reiterativo === 2) {
                        $sancion->reiterativo = 3;
                        $sancion->desvinculacion = true;
                        $message = 'Este trabajador ya tiene 2 suspenciones anteriores. Se procederá a registrar una DESVINCULACIÓN.';
                    }
                }

                $dias_sancion = new DiasSancion($data['fecha_incidencia'], $dias_suspencion);

                $sancion->observacion = $message . ' ' . $data['observacion'];
                $sancion->fecha_salida  = $dias_sancion->getDiaIncio();
                $sancion->fecha_regreso = $dias_sancion->getDiaTermino();
                $sancion->total_horas   = $dias_sancion->getCantidadHotasEfectivas();
            } else {
                $sancion->observacion = isset($data['observacion']) ? $data['observacion'] : null;
                $sancion->fecha_salida = null;
                $sancion->fecha_regreso = null;
                $sancion->total_horas = 0;
            }

            if ( $sancion->save() ) {
                DB::commit();
                return [
                    'error'   => false,
                    'rut' => $sancion->trabajador->rut,
                    'message' => 'Sanción ' . (isset($data['id']) ? 'actualizada' : 'creada') . ' correctamente' . '<br />' . $message,
                    'id'      => $sancion->id,
                    'desvinculacion' => $sancion->desvinculacion
                ];
            }

            DB::rollBack();
            return 0;
        } catch(\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }

    public static function _getUsuariosCarga($fechas, $estado, $incidencia_id)
    {
        $usuarios = DB::table('usuarios as u')
            ->select(
                'u.id',
                'u.username',
                DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo_usuario')
            )
            ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id');

        return DB::table('sanciones as f')
            ->select(
                DB::raw('MIN(usuario_id) as id'),
                'usuario.username as usuario',
                'usuario.nombre_completo_usuario as nombre_completo'
            )
            ->joinSub($usuarios, 'usuario', function($join) {
                $join->on('usuario.id', '=', 'f.usuario_id');
            })
            ->join('incidencias as i', 'i.id', '=', 'f.incidencia_id')
            ->when($incidencia_id != "0", function($query) use ($incidencia_id) {
                $query->where('i.documento', $incidencia_id);
            })
            ->where('f.estado', $estado)
            ->groupBy('usuario')
            ->get();
    }

    public static function _getAll(int $usuario_id, array $fechas, int $estado=0, string $incidencia_id="0", $usuario_carga_id)
    {
        $usuario = Usuario::find($usuario_id);

        if ($incidencia_id != "0") {
            $incidencia_id = $incidencia_id == "1" ? 'MEMORANDUM' : 'SUSPENCION';
        }

        if ( !$usuario ) {
            return [
                'error' => true,
                'message' => 'No se encontro el usuario'
            ];
        }

        if ( $usuario->sanciones == 1 || $usuario->sanciones == 3 ) {
            return DB::table('sanciones as f')
                ->select(
                    'f.id',
                    DB::raw('DATE_FORMAT(f.fecha_solicitud, "%d/%m/%Y") fecha_solicitud'),
                    'f.observacion',
                    'f.desvinculacion',
                    't.rut',
                    't.code',
                    DB::raw('CONCAT(t.apellido_paterno, " ", t.apellido_materno, " ", t.nombre) as nombre_completo'),
                    'i.documento as documento',
                    'z.code as zona_labor_id',
                    'z.name as zona_labor',
                    'i.name as incidencia',
                    DB::raw('DATE_FORMAT(f.fecha_incidencia, "%d/%m/%Y") fecha_incidencia'),
                    DB::raw('DATE_FORMAT(f.fecha_salida, "%d/%m/%Y") desde'),
                    DB::raw('DATE_FORMAT(f.fecha_regreso, "%d/%m/%Y") hasta'),
                    'f.total_horas as horas',
                    'e.shortname as empresa',
                    'f.estado',
                    're.name as regimen',
                    'o.name  as oficio'
                )
                ->join('trabajadores as t', 't.id', '=', 'f.trabajador_id')
                ->join('empresas as e', 'e.id', '=', 'f.empresa_id')
                ->join('zona_labores as z', 'z.id', '=', 'f.zona_labor_id')
                ->join('incidencias as i', 'i.id', '=', 'f.incidencia_id')
                ->leftJoin('regimenes as re', 're.id', '=', 'f.regimen_id')
                ->join('oficios as o', 'o.id', '=', 'f.oficio_id')
                ->where('f.usuario_id', $usuario->id)
                ->where('f.estado', $estado)
                ->when($incidencia_id != "0", function($query) use ($incidencia_id) {
                    $query->where('i.documento', $incidencia_id);
                })
                ->when($estado == 2, function($query) use ($fechas) {
                    $query->whereBetween('f.fecha_solicitud', [$fechas['desde'], $fechas['hasta']]);
                })
                ->orderBy('f.id', 'ASC')
                ->get();
        } else if ( $usuario->sanciones == 2 ) {
            $usuarios = DB::table('usuarios as u')
                ->select(
                    'u.id',
                    'u.username',
                    DB::raw('CONCAT(t.apellido_paterno, " ", t.apellido_materno, " ", t.nombre) as nombre_completo_usuario')
                )
                ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id');

            return DB::table('sanciones as f')
                ->select(
                    'f.id',
                    DB::raw('DATE_FORMAT(f.fecha_solicitud, "%d/%m/%Y") fecha_solicitud'),
                    'f.observacion',
                    'f.desvinculacion',
                    't.rut',
                    't.code',
                    DB::raw('CONCAT(t.apellido_paterno, " ", t.apellido_materno, " ", t.nombre) as nombre_completo'),
                    'i.documento as documento',
                    'z.code as zona_labor_id',
                    'z.name as zona_labor',
                    'i.name as incidencia',
                    DB::raw('DATE_FORMAT(f.fecha_incidencia, "%d/%m/%Y") fecha_incidencia'),
                    DB::raw('DATE_FORMAT(f.fecha_salida, "%d/%m/%Y") desde'),
                    DB::raw('DATE_FORMAT(f.fecha_regreso, "%d/%m/%Y") hasta'),
                    'f.total_horas as horas',
                    'e.shortname as empresa',
                    'f.estado',
                    're.name as regimen',
                    'o.name  as oficio',
                    'usuario.nombre_completo_usuario as nombre_completo_usuario'
                )
                ->join('trabajadores as t', 't.id', '=', 'f.trabajador_id')
                ->join('empresas as e', 'e.id', '=', 'f.empresa_id')
                ->join('zona_labores as z', 'z.id', '=', 'f.zona_labor_id')
                ->join('incidencias as i', 'i.id', '=', 'f.incidencia_id')
                ->leftJoin('regimenes as re', 're.id', '=', 'f.regimen_id')
                ->join('oficios as o', 'o.id', '=', 'f.oficio_id')
                ->joinSub($usuarios, 'usuario', function($join) {
                    $join->on('usuario.id', '=', 'f.usuario_id');
                })
                ->where('f.estado', $estado)
                ->when($incidencia_id != "0", function($query) use ($incidencia_id) {
                    $query->where('i.documento', $incidencia_id);
                })
                ->when($usuario_carga_id !== 0, function($query) use ($usuario_carga_id) {
                    $query->where('usuario.id', $usuario_carga_id);
                })
                ->when($estado == 2, function($query) use ($fechas) {
                    $query->whereBetween('f.fecha_solicitud', [$fechas['desde'], $fechas['hasta']]);
                })
                ->orderBy('f.id', 'ASC')
                ->get();
        } else if ( $usuario->sanciones == 4 ) {
            $usuarios = DB::table('usuarios as u')
                ->select(
                    'u.id',
                    'u.username',
                    DB::raw('CONCAT(t.apellido_paterno, " ", t.apellido_materno, " ", t.nombre) as nombre_completo_usuario')
                )
                ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id')
                ->whereIn('u.sanciones', [3, 4]);

            return DB::table('sanciones as f')
                ->select(
                    'f.id',
                    DB::raw('DATE_FORMAT(f.fecha_solicitud, "%d/%m/%Y") fecha_solicitud'),
                    'f.observacion',
                    'f.desvinculacion',
                    't.rut',
                    't.code',
                    DB::raw('CONCAT(t.apellido_paterno, " ", t.apellido_materno, " ", t.nombre) as nombre_completo'),
                    'i.documento as documento',
                    'z.code as zona_labor_id',
                    'z.name as zona_labor',
                    'i.name as incidencia',
                    DB::raw('DATE_FORMAT(f.fecha_incidencia, "%d/%m/%Y") fecha_incidencia'),
                    DB::raw('DATE_FORMAT(f.fecha_salida, "%d/%m/%Y") desde'),
                    DB::raw('DATE_FORMAT(f.fecha_regreso, "%d/%m/%Y") hasta'),
                    'f.total_horas as horas',
                    'e.shortname as empresa',
                    'f.estado',
                    're.name as regimen',
                    'o.name  as oficio',
                    'usuario.nombre_completo_usuario as nombre_completo_usuario'
                )
                ->join('trabajadores as t', 't.id', '=', 'f.trabajador_id')
                ->join('empresas as e', 'e.id', '=', 'f.empresa_id')
                ->join('zona_labores as z', 'z.id', '=', 'f.zona_labor_id')
                ->join('incidencias as i', 'i.id', '=', 'f.incidencia_id')
                ->leftJoin('regimenes as re', 're.id', '=', 'f.regimen_id')
                ->join('oficios as o', 'o.id', '=', 'f.oficio_id')
                ->joinSub($usuarios, 'usuario', function($join) {
                    $join->on('usuario.id', '=', 'f.usuario_id');
                })
                ->where('f.estado', $estado)
                ->when($incidencia_id != "0", function($query) use ($incidencia_id) {
                    $query->where('i.documento', $incidencia_id);
                })
                ->when($usuario_carga_id !== 0, function($query) use ($usuario_carga_id) {
                    $query->where('usuario.id', $usuario_carga_id);
                })
                ->when($estado == 2, function($query) use ($fechas) {
                    $query->whereBetween('f.fecha_solicitud', [$fechas['desde'], $fechas['hasta']]);
                })
                ->orderBy('f.id', 'ASC')
                ->get();
        } else {
            return [];
        }
    }

    public static function marcarEnviado(int $usuario_id, int $id)
    {
        $sancion = Sancion::find($id);
        $usuario = Usuario::find($usuario_id);

        if ( $usuario->id !== $sancion->usuario_id ) {
            return [
                'error'   => true,
                'message' => 'La misma persona que cargó este formulario debe marcarlo como enviado'
            ];
        }

        $sancion->estado = 1;
        $sancion->fecha_hora_enviado = now()->toDateTimeString();

        if ( $sancion->save() ) {
            return [
                'message' => 'Estado actualizado correctamente'
            ];
        }

        return [
            'error'   => true,
            'message' => 'No se pudo resolver esta operación'
        ];
    }

    public static function marcarSubido(int $usuario_id, int $id)
    {
        $sancion = Sancion::find($id);
        $usuario = Usuario::find($usuario_id);

        if ( $usuario->sanciones < 2 ) {
            return [
                'error' => 'Solo un usuario administrador puede marcar este formulario como CARGADO'
            ];
        }

        $sancion->estado = 2;
        $sancion->fecha_hora_subido = now()->toDateTimeString();

        if ( $sancion->save() ) {
            return [
                'message' => 'Sancion actualizada correctamente'
            ];
        }

        return [
            'error'   => true,
            'message' => 'No se pudo resolver esta operación'
        ];
    }
}
