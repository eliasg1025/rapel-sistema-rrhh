<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cuenta extends Model
{
    protected $table = 'cuentas';

    public function getFechaFormatAttribute()
    {
        return Carbon::parse($this->fecha_solicitud)->format('d/m/Y');
    }

    /**
     * Eloquent relationships
     */

    public function trabajador()
    {
        return $this->belongsTo('App\Models\Trabajador');
    }

    public function banco()
    {
        return $this->belongsTo('App\Models\Banco');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario');
    }

    public static function _getAll(int $usuario_id, array $fechas)
    {
        $usuario = Usuario::find($usuario_id);

        if (!$usuario) {
            return [
                'error' => true,
                'message' => 'No se encontró el usuario mencionado'
            ];
        }

        if ($usuario->cuentas !== 2) {
            return [
                'error' => true,
                'message' => 'No tiene acceso a esta información'
            ];
        }

        $usuarios = DB::table('usuarios as u')
            ->select(
                'u.id',
                'u.username',
                DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo_usuario')
            )
            ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id');

        $cuentas = DB::table('cuentas as c')
            ->select(
                'c.id as id',
                'c.fecha_solicitud',
                't.rut',
                DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                'b.name as banco_name',
                'c.numero_cuenta',
                'usuario.username as usuario',
                'usuario.nombre_completo_usuario as nombre_completo_usuario',
                'c.apertura',
                'e.shortname as empresa'
            )
            ->join('trabajadores as t', 't.id', '=', 'c.trabajador_id')
            ->join('bancos as b', 'b.id', '=', 'c.banco_id')
            ->join('empresas as e', 'e.id', '=', 'c.empresa_id')
            ->joinSub($usuarios, 'usuario', function($join) {
                $join->on('usuario.id', '=', 'c.usuario_id');
            })
            ->whereBetween('c.fecha_solicitud', [$fechas['desde'], $fechas['hasta']])
            ->get();

        return $cuentas;
    }

    public static function _getByUsuario(int $usuario_id)
    {
        return DB::table('cuentas as c')
            ->select(
                'c.id as id',
                'c.fecha_solicitud',
                't.rut',
                DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                'b.name as banco_name',
                'c.numero_cuenta',
                'e.shortname as empresa'
            )
            ->join('trabajadores as t', 't.id', '=', 'c.trabajador_id')
            ->join('bancos as b', 'b.id', '=', 'c.banco_id')
            ->join('empresas as e', 'e.id', '=', 'c.empresa_id')
            ->where([
                'c.fecha_solicitud' => Carbon::now()->format('Y-m-d'),
                'c.usuario_id' => $usuario_id
            ])
            ->get();
    }

    public static function _create(array $data)
    {
        DB::beginTransaction();
        try {
            $banco_id = Banco::findOrCreate($data['banco']);

            if (!isset($data['id'])) { // Si es que no viene el parametro id (actualizar registro), se crea uno nuevo
                $trabajador_id = Trabajador::findOrCreate($data['trabajador']);

                $existe_cuenta = Cuenta::where([
                    'trabajador_id' => $trabajador_id,
                    'fecha_solicitud' => $data['fecha_solicitud']
                ])->first();

                if ($existe_cuenta) {
                    DB::rollBack();
                    return [
                        'error' => 'Ya existe un cambio de cuenta para el ' . $data['fecha_solicitud'] . '<br /> CUENTA: ' . $existe_cuenta->numero_cuenta . '<br /> BANCO: ' . $existe_cuenta->banco->name
                    ];
                }

                $cuenta = new Cuenta();
                $cuenta->numero_cuenta = $data['numero_cuenta'];
                $cuenta->fecha_solicitud = $data['fecha_solicitud'];
                $cuenta->empresa_id = $data['empresa_id'];
                $cuenta->usuario_id = $data['usuario_id'];
                $cuenta->apertura = $data['apertura'];
                $cuenta->banco_id = $banco_id;
                $cuenta->trabajador_id = $trabajador_id;
            } else {
                $cuenta = Cuenta::find($data['id']);
                $cuenta->empresa_id = $data['empresa_id'];
                $cuenta->banco_id = $banco_id;
                $cuenta->numero_cuenta = $data['numero_cuenta'];
            }

            if ($cuenta->save()) {
                DB::commit();
                return [
                    'error' => false,
                    'message' => 'Cuenta creada correctamente',
                    'cuenta_id' => $cuenta->id
                ];
            }
            DB::rollBack();
            return 0;
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => true,
                'message' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }

    public static function _get($id)
    {
        return DB::table('cuentas as c')
            ->select(
                'c.id',
                'c.fecha_solicitud',
                'c.empresa_id',
                't.rut',
                DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_trabajador'),
                'b.code as banco_id',
                'c.numero_cuenta'
            )
            ->join('trabajadores as t', 't.id', '=', 'c.trabajador_id')
            ->join('bancos as b', 'b.id', '=', 'c.banco_id')
            ->where('c.id', $id)
            ->first();
    }
}
