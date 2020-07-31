<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AtencionReseteoClave extends Model
{
    protected $table = 'atenciones_reseteo_clave';

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
                    'error' => 'Ya existe un cambio de clave pendiente generado el ' . $existe_atencion_pendiente->fecha_solicitud
                ];
            }

            $atencion = new AtencionReseteoClave();
            $atencion->fecha_solicitud = $data['fecha_solicitud'];
            $atencion->trabajador_id = $trabajador_id;
            $atencion->empresa_id = $data['empresa_id'];
            $atencion->usuario_id = $data['usuario_id'];

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

    public static function _getAll(int $usuario_id, array $fechas)
    {
        $usuario = Usuario::find($usuario_id);

        if ( !$usuario ) {
            return [
                'error' => true,
                'message' => 'No se encontro el usuario'
            ];
        }

        if ( $usuario->reseteo_clave == 1 ) {
            return DB::table('atenciones_reseteo_clave as a')
                ->select(
                    'a.id',
                    'a.fecha_solicitud',
                    't.rut',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                    'e.shortname as empresa',
                    'a.estado'
                )
                ->join('trabajadores as t', 't.id', '=', 'a.trabajador_id')
                ->join('empresas as e', 'e.id', '=', 'a.empresa_id')
                ->where('a.usuario_id', '=', $usuario->id)
                ->whereBetween('a.fecha_solicitud', [$fechas['desde'], $fechas['hasta']])
                ->get();
        } else if ( $usuario->reseteo_clave == 2 ) {
            return DB::table('atenciones_reseteo_clave as a')
                ->select(
                    'a.id',
                    'a.fecha_solicitud',
                    't.rut',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                    'e.shortname as empresa',
                    'a.estado'
                )
                ->join('trabajadores as t', 't.id', '=', 'a.trabajador_id')
                ->join('empresas as e', 'e.id', '=', 'a.empresa_id')
                ->whereBetween('a.fecha_solicitud', [$fechas['desde'], $fechas['hasta']])
                ->get();
        }
    }

    public static function _getPendientes(int $usuario_id, array $data)
    {
        $usuario = Usuario::find($usuario_id);

        if ( !$usuario ) {
            return [
                'error'   => true,
                'message' => 'No se encontro el usuario'
            ];
        }
    }
}
