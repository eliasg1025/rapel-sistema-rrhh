<?php

namespace App\Models\SqlSrv;

use App\Models\Sancion;
use App\Models\Trabajador;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Covid extends Model
{
    public static function get($usuarios = [])
    {
        $result = DB::connection('sqlsrv')
            ->table('dbo.Covid as co')
            ->select(
                'co.id as id',
                'co.idempresa as empresa_id',
                'co.ruttrbajador as rut',
                'co.trabajador as nombre_completo',
                'co.zona as zona_labor',
                DB::raw('CAST(co.fecha as DATE) fecha_incidencia'),
                'co.hora as hora_incidencia',
                'co.causa as incidencia',
                'co.observacion as observacion',
                'co.usuario',
                'tra.ruttrabajador as rut_usuario',
                'tra.Apellidopaterno as apellido_paterno_usuario',
                'tra.Apellidomaterno as apellido_materno_usuario',
                'tra.Nombre as nombre_usuario',
            )
            ->join('dbo.Trabajador as tra', 'tra.UsuarioSis', 'co.usuario')
            ->whereDate('co.fecha', '>=', '2020-09-28')
            ->whereIn('co.IdEmpresa', [9, 14])
            ->whereIn('co.Causa', ['SIN MASCARILLA', 'SIN ALCOHOL'])
            ->when(sizeof($usuarios) > 0, function($query) use ($usuarios) {
                $query->whereIn('co.usuario', $usuarios);
            })
            ->orderBy('fecha_incidencia', 'DESC')
            ->orderBy('co.hora', 'DESC')
            ->get();

        return $result;
    }

    public static function getSlavesUsername(Usuario $usuario)
    {
        $usuarios_sanciones = DB::table('usuarios_sanciones as us')
                ->join('usuarios as u', 'u.id', '=', 'us.usuario2_id')
                ->where([
                    'usuario_id' => $usuario->id,
                ])
                ->get();

        $usuarios_sanciones->transform(function ($item) {
            return $item->username;
        });

        return [ $usuario->username, ...$usuarios_sanciones ];
    }

    public static function getOne($id)
    {
        $result = DB::connection('sqlsrv')
            ->table('dbo.Covid as co')
            ->select(
                'co.id as id',
                'co.idempresa as empresa_id',
                'co.ruttrbajador as rut',
                'co.trabajador as nombre_completo',
                'co.zona as zona_labor',
                DB::raw('CAST(co.fecha as DATE) fecha_incidencia'),
                'co.hora as hora_incidencia',
                'co.causa as incidencia',
                'co.observacion as observacion',
                'co.usuario',
                'tra.ruttrabajador as rut_usuario',
                'tra.Apellidopaterno as apellido_paterno_usuario',
                'tra.Apellidomaterno as apellido_materno_usuario',
                'tra.Nombre as nombre_usuario',
            )
            ->join('dbo.Trabajador as tra', 'tra.UsuarioSis', 'co.usuario')
            ->whereIn('co.IdEmpresa', [9, 14])
            ->whereIn('co.Causa', ['SIN MASCARILLA', 'SIN ALCOHOL'])
            ->where('co.id', $id)
            ->first();

        return $result;
    }

    public static function sync($rows)
    {
        $actualizados = 0;

        foreach ($rows as $row)
        {
            $actualizados = $actualizados + self::createEstadoCovid($row);
        }

        return $actualizados;
    }

    public static function createEstadoCovid($row)
    {
        $registro = DB::connection('mysql')
            ->table('estados_covid')
            ->where('covid_id', $row->id)
            ->first();

        if ( $registro ) {
            return 0;
        }

        $usuario = Usuario::where('username', $row->usuario)->first();

        if ( !$usuario ) {
            return 0;
        }

        return DB::connection('mysql')
            ->table('estados_covid')
            ->insert([
                'created_at' => now()->toDateString(),
                'updated_at' => now()->toDateString(),
                'covid_id'   => $row->id,
                'usuario_id' => $usuario->id
            ]);
    }

    public static function getEstadosCovid($usuario_id, $estados)
    {
        $userSlavesId = DB::table('usuarios_sanciones as us')
            ->join('usuarios as u', 'u.id', '=', 'us.usuario2_id')
            ->where([
                'usuario_id' => $usuario_id,
            ])
            ->get();

        $userSlavesId->transform(function ($item) {
            return $item->id;
        });

        $dataset = DB::connection('mysql')
            ->table('estados_covid')
            ->when($usuario_id, function ($query) use ($usuario_id, $userSlavesId) {
                $query->whereIn('usuario_id', [$usuario_id, ...$userSlavesId]);
            })
            ->whereIn('estado', $estados)
            ->orderBy('covid_id', 'DESC')
            ->get();

        $dataset->transform(function($item) {
            $item->covid = self::getOne($item->covid_id);
            return $item;
        });

        return $dataset;
    }

    public static function toggleValido($tipo, $ids)
    {
        return DB::table('estados_covid')
            ->whereIn('id', $ids)
            ->update([
                'estado' => $tipo
            ]);
    }

    public static function terminarProceso($ids)
    {
        DB::beginTransaction();

        try {
            foreach ($ids as $id) {
                $estado_covid = DB::table('estados_covid')->where('id', $id)->first();

                if ( $estado_covid->estado === 0 ) {
                    DB::table('estados_covid')
                        ->where('id', $id)
                        ->update([
                            'estado' => 3 // PARA ANALISTA
                        ]);
                } else {
                    DB::table('estados_covid')
                        ->where('id', $id)
                        ->update([
                            'estado' => 2 // RECHAZADO
                        ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }

    public static function getSupervisoresSst()
    {
        $result = Usuario::where('sanciones', 3)
            ->get();

        $result->transform(function($item) {

            $item->trabajador = Trabajador::where('id', $item->trabajador_id)->first();

            return $item;
        });

        return $result;
    }

    public static function generarSanciones($data)
    {
        $dataset = self::obtenerDataParaSanciones($data);

        $registro = [];
        foreach($dataset as $row)
        {
            if ( isset($row['error']) ) {
                $result = $row['error'];
            } else {
                $result = Sancion::_create($row);
            }

            if ( is_bool($result['error']) ) {
                DB::table('estados_covid')
                    ->where('id', $row['key'])
                    ->update([
                        'estado' => 5
                    ]);
            }

            array_push($registro, $result);
        }

        return $registro;
    }

    public static function obtenerDataParaSanciones($data)
    {
        $result = [];
        foreach ($data as $row)
        {
            if ($row['estado'] === 4)
            {
                continue;
            }

            switch (trim($row['incidencia']))
            {
                case 'SIN MASCARILLA':
                    $incidencia_id = 1;
                    break;
                case 'SIN ALCOHOL':
                    $incidencia_id = 6;
                    break;
            }

            try {
                $trabajador = DB::connection('sqlsrv')
                    ->table('dbo.trabajador')
                    ->select(
                        'apellidopaterno as apellido_paterno',
                        'apellidomaterno as apellido_materno',
                        'idtrabajador as code',
                        'direccion as direccion',
                        'mail as email',
                        'idempresa as empresa_id',
                        'EstadoCivil as estado_civil_id',
                        'FechaNacimiento as fecha_nacimiento',
                        'IdNacionalidad as nacionalidad_id',
                        'nombre as nombre',
                        'NombreVia as nombre_via',
                        'NombreZona as nombre_zona',
                        'Sexo as sexo',
                        'RutTrabajador as rut',
                        'IdTipoVia as tipo_via_id',
                        'IdTipoZona as tipo_zona_id',
                        'COD_COM as distrito_id'
                    )
                    ->where('rutTrabajador', $row['rut'])
                    ->where('idEmpresa', $row['empresa_id'])
                    ->first();

                $oficio = DB::connection('sqlsrv')
                    ->table('dbo.Contratos as c')
                    ->select(
                        'o.idOficio as id',
                        'o.descripcion as name',
                        'o.idEmpresa as empresa_id'
                    )
                    ->where('c.ruttrabajador', $row['rut'])
                    ->where('c.idempresa', $row['empresa_id'])
                    ->where('c.indicadorVigencia', '1')
                    ->join('dbo.Oficio as o', 'o.idempresa', '=', 'c.idempresa')
                    ->first();

                $zona_labor = DB::connection('sqlsrv')
                    ->table('dbo.Zona')
                    ->select(
                        'IdZona as id',
                        'IdEmpresa as empresa_id',
                        'Nombre as name'
                    )
                    ->where('Nombre', $row['zona_labor'])
                    ->where('idEmpresa', $row['empresa_id'])
                    ->first();

                if ( !$zona_labor ) {
                    $zona_labor = DB::connection('sqlsrv')
                        ->table('dbo.Zona')
                        ->select(
                            'IdZona as id',
                            'IdEmpresa as empresa_id',
                            'Nombre as name'
                        )
                        ->where('Nombre', 'TERCEROS')
                        ->where('idEmpresa', $row['empresa_id'])
                        ->first();
                }

                array_push($result, [
                    'key'              => $row['key'],
                    'incidencia_id'    => $incidencia_id,
                    'trabajador'       => json_decode(json_encode($trabajador), true),
                    'zona_labor'       => json_decode(json_encode($zona_labor), true),
                    'oficio'           => json_decode(json_encode($oficio), true),
                    'fecha_incidencia' => $row['fecha_incidencia'],
                    'observacion'      => $row['observacion'],
                    'usuario_id'       => $row['usuario_id'],
                    'empresa_id'       => $row['empresa_id'],
                    'fecha_solicitud'  => now()->toDateString(),
                ]);

            } catch (\Exception $e) {
                array_push($result, [
                    'rut'   => $row['rut'],
                    'error' => $e->getMessage() . ' -- ' . $e->getLine()
                ]);
            }
        }

        return $result;
    }
}
