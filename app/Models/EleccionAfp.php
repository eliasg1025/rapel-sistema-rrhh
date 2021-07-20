<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EleccionAfp extends Model
{
    protected $table = 'elecciones_afp';

    public function getFechaLargaAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_inicio);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }

    public function getFechaLargaSolicitudAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_solicitud);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }

    public function getAnioContratoAttribute($value)
    {
        return Carbon::parse($this->fecha_solicitud)->format('Y');
    }

    public function trabajador()
    {
        return $this->belongsTo('App\Models\Trabajador');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public static function _create(array $data)
    {
        DB::beginTransaction();
        try {
            $afp_id = Afp::findOrCreate($data['afp']);

            if (!isset($data['id'])) {
                $trabajador_id = Trabajador::findOrCreate($data['trabajador']);
                $existe = EleccionAfp::where([
                    'trabajador_id' => $trabajador_id
                ])->first();

                if ($existe) {
                    DB::rollBack();
                    return [
                        'error' => 'Ya existe un registro de Elección de AFP del día ' . $existe->fecha_solicitud
                    ];
                }

                $eleccion_afp = new EleccionAfp();
                $eleccion_afp->remuneracion = $data['remuneracion'] ?? null;
                $eleccion_afp->fecha_solicitud = now()->toDateString();
                $eleccion_afp->fecha_inicio = $data['fecha_inicio'];
                $eleccion_afp->empresa_id = $data['empresa_id'];
                $eleccion_afp->usuario_id = $data['usuario_id'];
                $eleccion_afp->afp_id = $afp_id;
                $eleccion_afp->trabajador_id = $trabajador_id;
            } else {
                $eleccion_afp = EleccionAfp::find($data['id']);
                $eleccion_afp->empresa_id = $data['empresa_id'];
                $eleccion_afp->afp_id = $afp_id;
                $eleccion_afp->remuneracion = $data['remuneracion'] ?? null;
            }

            if ( $eleccion_afp->save() ) {
                DB::commit();
                return [
                    'error' => false,
                    'message' => 'Eleccion AFP creada correctamente',
                    'id' => $eleccion_afp->id
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

    public static function _getAll(int $usuario_id, array $fechas)
    {
        $usuario = Usuario::find($usuario_id);

        if (!$usuario) {
            return [
                'error' => true,
                'message' => 'No se encontró el usuario mencionado'
            ];
        }

        $usuarios = DB::table('usuarios as u')
            ->select(
                'u.id',
                'u.username',
                DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo_usuario')
            )
            ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id');

        $data = DB::table('elecciones_afp as ea')
            ->select(
                'ea.id',
                'ea.empresa_id',
                'ea.fecha_solicitud',
                't.rut',
                DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                'e.shortname as empresa',
                'usuario.username as usuario',
                'usuario.nombre_completo_usuario as nombre_completo_usuario',
            )
            ->join('trabajadores as t', 't.id', '=', 'ea.trabajador_id')
            ->join('empresas as e', 'e.id', '=', 'ea.empresa_id')
            ->joinSub($usuarios, 'usuario', function($join) {
                $join->on('usuario.id', '=', 'ea.usuario_id');
            })
            ->whereBetween('ea.fecha_solicitud', [$fechas['desde'], $fechas['hasta']])
            ->when($usuario->afp === 1, function($query) use ($usuario) {
                $query->where('ea.usuario_id', '=', $usuario->id);
            })
            ->get();

        /* $ruts = DB::table('elecciones_afp as ea')
            ->join('trabajadores as t', 't.id', '=', 'ea.trabajador_id')
            ->whereBetween('ea.fecha_solicitud', [$fechas['desde'], $fechas['hasta']])
            ->pluck('t.rut'); */

        $ruts = $data->pluck('rut');

        $ultimosContratos = DB::connection('sqlsrv')
            ->table('Contratos as c')
            ->select([
                'c.RutTrabajador as rut',
                DB::raw('MAX(c.FechaInicio) as fecha_inicio')
            ])
            ->whereIn('c.IdEmpresa', [9, 14])
            ->whereIn('c.RutTrabajador', $ruts)
            ->groupBy('c.RutTrabajador');

        $infoContratos = DB::connection('sqlsrv')
            ->table('Contratos as c')
            ->select([
                'c.RutTrabajador as rut',
                'r.Descripcion as regimen',
                'o.Descripcion as oficio'
            ])
            ->joinSub($ultimosContratos, 'ultimos_contratos', function($join) {
                $join->on([
                    'c.RutTrabajador' => 'ultimos_contratos.rut',
                    'c.FechaInicio' => 'ultimos_contratos.fecha_inicio'
                ]);
            })
            ->join('Oficio as o', [
                'c.IdEmpresa' => 'o.IdEmpresa',
                'c.IdOficio' => 'o.IdOficio'
            ])
            ->join('TipoRegimen as r', [
                'r.IdTipo' => 'c.IdRegimen'
            ])->get();

        $data->transform(function ($item) use ($infoContratos) {
            $d = $infoContratos->where('rut', $item->rut)->first();
            if ($d) {
                $item->regimen = $d->regimen;
                $item->oficio = $d->oficio;
            }
            return $item;
        });

        return $data;
    }

    public static function _getByUser(Usuario $id)
    {

    }
}
