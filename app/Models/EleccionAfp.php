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

        $data = DB::table('elecciones_afp as ea')
            ->select(
                'ea.id',
                'ea.fecha_solicitud',
                't.rut',
                DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                'e.shortname as empresa'
            )
            ->join('trabajadores as t', 't.id', '=', 'ea.trabajador_id')
            ->join('empresas as e', 'e.id', '=', 'ea.empresa_id')
            ->whereBetween('ea.fecha_solicitud', [$fechas['desde'], $fechas['hasta']])
            ->get();

        return $data;
    }

    public static function _getByUser(Usuario $id)
    {

    }
}
