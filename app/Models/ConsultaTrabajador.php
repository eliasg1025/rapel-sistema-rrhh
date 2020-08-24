<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ConsultaTrabajador extends Model
{
    public $table = 'consultas_trabajadores';

    public static function _create($data)
    {
        try {
            $consulta = new ConsultaTrabajador();
            $consulta->rut = $data['rut'];
            $consulta->activo = $data['activo'];
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

    public static function _get()
    {
        $usuarios = DB::table('usuarios as u')
                ->select(
                    'u.id',
                    'u.username',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo_usuario')
                )
                ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id');

        return DB::table('consultas_trabajadores as ct')
            ->select(
                'ct.id',
                'ct.created_at',
                'ct.rut',
                'ct.activo',
                'usuario.nombre_completo_usuario as usuario'
            )
            ->joinSub($usuarios, 'usuario', function($join) {
                $join->on('usuario.id', '=', 'ct.usuario_id');
            })
            ->orderBy('ct.created_at', 'DESC')
            ->get();
    }
}
