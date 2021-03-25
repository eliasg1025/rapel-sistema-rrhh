<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AtencionReseteoClave extends Model
{
    protected $table = 'atenciones_reseteo_clave';

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public static function _create(array $data)
    {
        DB::beginTransaction();
        try {

            $trabajador_id = Trabajador::findOrCreate($data['trabajador']);
            $contrato_activo = $data['contratoActivo'];
            $existe_atencion_pendiente = AtencionReseteoClave::where([
                'trabajador_id' => $trabajador_id,
                'estado' => 0
            ])->first();

            if ($existe_atencion_pendiente) {
                DB::rollBack();
                return [
                    'error' => true,
                    'message' => 'Ya existe un cambio de clave pendiente generado el ' . $existe_atencion_pendiente->fecha_solicitud
                ];
            }

            $atencion = new AtencionReseteoClave();
            $atencion->fecha_solicitud = $data['fecha_solicitud'];
            $atencion->trabajador_id = $trabajador_id;
            $atencion->empresa_id = $data['empresa_id'];
            $atencion->usuario_id = $data['usuario_id'];
            $atencion->regimen_id = $contrato_activo['regimen_id'];
            $atencion->oficio_id = Oficio::findOrCreate($contrato_activo['oficio']);
            if ((isset($contrato_activo['sueldo_bruto']) && $contrato_activo['sueldo_bruto'] >= 2000) || $contrato_activo['zona_labor']['id'] == 55) {
                $atencion->sueldo_bruto = $contrato_activo['sueldo_bruto'];
                $atencion->numero_telefono_trabajador = $data['numero_telefono_trabajador'];
                $atencion->numero_telefono_rrhh = '981269819'; // TEMP

                $atencion->restringido = true;
            } else {
                $exploded = explode("-", $atencion->fecha_solicitud);
                $exploded = array_reverse($exploded);
                $atencion->clave = strtolower($atencion->empresa->shortname) . $exploded[0] . $exploded[1];
                $atencion->restringido = false;
            }

            if ( $atencion->save() ) {
                DB::commit();
                return [
                    'error'   => false,
                    'message' => 'Registro guardado correctamente',
                    'id'      => $atencion->id,
                ];
            }
            DB::rollBack();
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => true,
                'message' => $e->getMessage() . ' -- ' , $e->getLine()
            ];
        }
    }

    public static function _getAll(int $usuario_id, array $fechas, int $estado=0, int $usuario_carga_id, $rut, $tipo)
    {
        $usuario = Usuario::find($usuario_id);

        if ( !$usuario ) {
            return [
                'error' => true,
                'message' => 'No se encontro el usuario'
            ];
        }

        if ( $usuario->reseteo_clave == 1 ) {
            $usuarios = DB::table('usuarios as u')
                ->select(
                    'u.id',
                    'u.username',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo_usuario')
                )
                ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id');

            return DB::table('atenciones_reseteo_clave as a')
                ->select(
                    'a.id',
                    'a.fecha_solicitud',
                    DB::raw('DATE_FORMAT(a.created_at, "%H:%i:%s") hora'),
                    't.rut',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                    'e.shortname as empresa',
                    'a.estado',
                    'a.clave',
                    'a.numero_telefono_rrhh',
                    'a.numero_telefono_trabajador',
                    'a.restringido',
                    'o.name as oficio',
                    'r.name as regimen'
                )
                ->when($estado == 1, function($query) use ($usuarios) {
                    $query->joinSub($usuarios, 'usuario2', function($join) {
                        $join->on('usuario2.id', '=', 'a.usuario2_id');
                    })->addSelect(
                        'usuario2.username as usuario2',
                        'usuario2.nombre_completo_usuario as nombre_completo_usuario2'
                    );
                })
                ->join('trabajadores as t', 't.id', '=', 'a.trabajador_id')
                ->join('empresas as e', 'e.id', '=', 'a.empresa_id')
                ->leftJoin('oficios as o', 'o.id', '=', 'a.oficio_id')
                ->leftJoin('regimenes as r', 'r.id', '=', 'a.regimen_id')
                ->where('a.usuario_id', '=', $usuario->id)
                ->where('a.estado', $estado)
                ->when($estado != 0, function($query) use ($fechas) {
                    $query->whereBetween('a.fecha_solicitud', [$fechas['desde'], $fechas['hasta']]);
                })
                ->when(($rut !== '' || !is_null($rut)) && is_numeric($rut), function($query) use ($rut) {
                    $query->where('t.rut', 'like', $rut . '%');
                })
                ->orderBy('a.id', 'ASC')
                ->get();
        } else if ( $usuario->reseteo_clave == 2 ) {
            $usuarios = DB::table('usuarios as u')
                ->select(
                    'u.id',
                    'u.username',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo_usuario')
                )
                ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id');

            $registrosPorTrabajador = DB::table('atenciones_reseteo_clave as x')
                ->select(
                    'x.trabajador_id as id',
                    DB::raw('COUNT(*) as cantidad_registros')
                )
                ->groupBy('x.trabajador_id');

            return DB::table('atenciones_reseteo_clave as a')
                ->select(
                    'a.id',
                    'a.fecha_solicitud',
                    DB::raw('DATE_FORMAT(a.created_at, "%H:%i:%s") hora'),
                    't.rut',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                    'e.shortname as empresa',
                    'a.estado',
                    'a.clave',
                    'usuario.username as usuario',
                    'usuario.nombre_completo_usuario as nombre_completo_usuario',
                    'a.numero_telefono_rrhh',
                    'a.numero_telefono_trabajador',
                    'a.restringido',
                    'o.name as oficio',
                    'r.name as regimen',
                    'registros.cantidad_registros',
                )
                ->when($estado == 1, function($query) use ($usuarios) {
                    $query->joinSub($usuarios, 'usuario2', function($join) {
                        $join->on('usuario2.id', '=', 'a.usuario2_id');
                    })->addSelect(
                        'usuario2.username as usuario2',
                        'usuario2.nombre_completo_usuario as nombre_completo_usuario2'
                    );
                })
                ->joinSub($usuarios, 'usuario', function($join) {
                    $join->on('usuario.id', '=', 'a.usuario_id');
                })
                ->leftJoin('oficios as o', 'o.id', '=', 'a.oficio_id')
                ->leftJoin('regimenes as r', 'r.id', '=', 'a.regimen_id')
                ->join('trabajadores as t', 't.id', '=', 'a.trabajador_id')
                ->join('empresas as e', 'e.id', '=', 'a.empresa_id')
                ->leftJoinSub($registrosPorTrabajador, 'registros', function ($join) {
                    $join->on('registros.id', '=', 'a.trabajador_id');
                })
                ->where('a.estado', $estado)
                ->when($usuario_carga_id !== 0, function($query) use ($usuario_carga_id) {
                    $query->where('usuario.id', $usuario_carga_id);
                })
                ->when($estado != 0, function($query) use ($fechas) {
                    $query->whereBetween('a.fecha_solicitud', [$fechas['desde'], $fechas['hasta']]);
                })
                ->when(($rut !== '' || !is_null($rut)) && is_numeric($rut), function($query) use ($rut) {
                    $query->where('t.rut', 'like', $rut . '%');
                })
                ->orderBy('a.id', 'ASC')
                ->get();
        } else if ( $usuario->reseteo_clave == 3 ) {
            $usuarios = DB::table('usuarios as u')
                ->select(
                    'u.id',
                    'u.username',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo_usuario')
                )
                ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id');

            $registrosPorTrabajador = DB::table('atenciones_reseteo_clave as x')
                ->select(
                    'x.trabajador_id as id',
                    DB::raw('COUNT(*) as cantidad_registros')
                )
                ->groupBy('x.trabajador_id');

            return DB::table('atenciones_reseteo_clave as a')
                ->select(
                    'a.id',
                    'a.fecha_solicitud',
                    DB::raw('DATE_FORMAT(a.created_at, "%H:%i:%s") hora'),
                    't.rut',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                    'e.shortname as empresa',
                    'a.estado',
                    'a.clave',
                    'usuario.username as usuario',
                    'usuario.nombre_completo_usuario as nombre_completo_usuario',
                    'a.numero_telefono_rrhh',
                    'a.numero_telefono_trabajador',
                    'a.restringido',
                    'o.name as oficio',
                    'r.name as regimen',
                    'registros.cantidad_registros',
                )
                ->when($estado == 1, function($query) use ($usuarios) {
                    $query->joinSub($usuarios, 'usuario2', function($join) {
                        $join->on('usuario2.id', '=', 'a.usuario2_id');
                    })->addSelect(
                        'usuario2.username as usuario2',
                        'usuario2.nombre_completo_usuario as nombre_completo_usuario2'
                    );
                })
                ->joinSub($usuarios, 'usuario', function($join) {
                    $join->on('usuario.id', '=', 'a.usuario_id');
                })
                ->join('trabajadores as t', 't.id', '=', 'a.trabajador_id')
                ->join('empresas as e', 'e.id', '=', 'a.empresa_id')
                ->leftJoin('oficios as o', 'o.id', '=', 'a.oficio_id')
                ->leftJoin('regimenes as r', 'r.id', '=', 'a.regimen_id')
                ->leftJoinSub($registrosPorTrabajador, 'registros', function ($join) {
                    $join->on('registros.id', '=', 'a.trabajador_id');
                })
                ->where('a.estado', $estado)
                ->when($usuario_carga_id !== 0, function($query) use ($usuario_carga_id) {
                    $query->where('usuario.id', $usuario_carga_id);
                })
                ->when($estado != 0, function($query) use ($fechas) {
                    $query->whereBetween('a.fecha_solicitud', [$fechas['desde'], $fechas['hasta']]);
                })
                ->when(($rut !== '' || !is_null($rut)) && is_numeric($rut), function($query) use ($rut) {
                    $query->where('t.rut', 'like', $rut . '%');
                })
                ->when($tipo === 'RESTRINGIDO', function($query) {
                    $query->where('a.restringido', true);
                })
                ->orderBy('a.id', 'ASC')
                ->get();
        } else {
            return [];
        }
    }

    public static function _getUsuariosCarga(array $fechas, int $estado=0)
    {
        $usuarios = DB::table('usuarios as u')
                ->select(
                    'u.id',
                    'u.username',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo_usuario')
                )
                ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id');

        return DB::table('atenciones_reseteo_clave as a')
            ->select(
                DB::raw('MIN(usuario_id) as id'),
                'usuario.username as usuario',
                'usuario.nombre_completo_usuario as nombre_completo'
            )
            ->joinSub($usuarios, 'usuario', function($join) {
                $join->on('usuario.id', '=', 'a.usuario_id');
            })
            ->where('a.estado', $estado)
            ->whereBetween('a.fecha_solicitud', [$fechas['desde'], $fechas['hasta']])
            ->groupBy('usuario')
            ->get();
    }

    public static function resolver(int $usuario_id, int $id)
    {
        $atencion = AtencionReseteoClave::find($id);
        $usuario = Usuario::find($usuario_id);

        if ( $usuario->reseteo_clave == 1 ) {
            return [
                'error'   => true,
                'message' => 'No tiene autorización para realizar esta operación'
            ];
        }

        $atencion->estado = 1;
        $atencion->usuario2_id = $usuario->id;
        if ( $atencion->save() ) {
            return [
                'message' => 'Registro actualizado correctamente'
            ];
        }

        return [
            'error'   => true,
            'message' => 'No se pudo resolver esta operación'
        ];
    }
}
