<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConsultaSctr extends Model
{
    public $table = 'consultas_sctr';

    public static function _create($data)
    {
        try {
            $consulta = new ConsultaSctr();
            $consulta->rut = $data['rut'];
            $consulta->sctr = $data['sctr'];
            $consulta->nombre_completo = $data['nombre_completo'];
            $consulta->zona_labor = $data['zona_labor'];
            $consulta->oficio = $data['oficio'];
            $consulta->empresa_id = $data['empresa_id'];
            $consulta->usuario_id = $data['usuario_id'];
            if ($consulta->save() )  {
                return [
                    'message' => 'Guardado correctamente'
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public static function _get($usuario_id)
    {
        $usuario = Usuario::find($usuario_id);

        $usuarios = DB::table('usuarios as u')
                ->select(
                    'u.id',
                    'u.username',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo_usuario')
                )
                ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id');

        return DB::table('consultas_sctr as cs')
            ->select(
                'cs.id',
                'cs.created_at',
                'cs.rut',
                'cs.nombre_completo',
                'cs.zona_labor',
                'cs.oficio',
                'e.shortname as empresa',
                'cs.sctr',
                'usuario.nombre_completo_usuario as usuario'
            )
            ->join('empresas as e', 'e.id', '=', 'cs.empresa_id')
            ->joinSub($usuarios, 'usuario', function($join) {
                $join->on('usuario.id', '=', 'cs.usuario_id');
            })
            ->where('cs.usuario_id', $usuario->id)
            ->orderBy('cs.created_at', 'DESC')
            ->get();
    }
}
