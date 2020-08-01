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
            $exploded = explode("-", $atencion->fecha_solicitud);
            $exploded = array_reverse($exploded);
            $atencion->clave = strtolower($atencion->empresa->shortname) . $exploded[0] . $exploded[1];

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

    public static function _getAll(int $usuario_id, array $fechas, int $estado=0, int $usuario_carga_id)
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
                    't.rut',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                    'e.shortname as empresa',
                    'a.estado',
                    'a.clave',
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
                ->where('a.usuario_id', '=', $usuario->id)
                ->where('a.estado', $estado)
                ->whereBetween('a.fecha_solicitud', [$fechas['desde'], $fechas['hasta']])
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

            return DB::table('atenciones_reseteo_clave as a')
                ->select(
                    'a.id',
                    'a.fecha_solicitud',
                    't.rut',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                    'e.shortname as empresa',
                    'a.estado',
                    'a.clave',
                    'usuario.username as usuario',
                    'usuario.nombre_completo_usuario as nombre_completo_usuario',
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
                ->where('a.estado', $estado)
                ->whereBetween('a.fecha_solicitud', [$fechas['desde'], $fechas['hasta']])
                ->when($usuario_carga_id !== 0, function($query) use ($usuario_carga_id) {
                    $query->where('usuario.id', $usuario_carga_id);
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

        if ( $usuario->reseteo_clave != 2 ) {
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
