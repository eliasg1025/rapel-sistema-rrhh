<?php

namespace App\Models;

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

    public function getFechaIncidenciaLargoAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_incidencia);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }

    public static function _create(array $data)
    {
        DB::beginTransaction();
        try {
            if ( !isset($data['id']) ) {
                $trabajador_id     = Trabajador::findOrCreate($data['trabajador']);
                $regimen_id        = Regimen::findOrCreate($data['regimen']);
                $zona_labor_id     = ZonaLabor::findOrCreate($data['zona_labor']);
                $ofico_id          = Oficio::findOrCreate($data['oficio']);
                $cuartel_id        = Cuartel::findOrCreate($data['cuartel'], $zona_labor_id);

                // TODO: Comentado temporalmente para pruebas
                $existe_registro_mismo_dia = Sancion::where('trabajador_id', $trabajador_id)
                    ->whereDate('fecha_incidencia', $data['fecha_incidencia'])
                    ->where('incidencia_id', $data['incidencia_id'])
                    ->first();

                if ( $existe_registro_mismo_dia ) {
                    DB::rollBack();
                    return [
                        'error' => 'Ya existe una sanción para el ' . $data['fecha_incidencia'] . '<br />USUARIO: ' . $existe_registro_mismo_dia->usuario->trabajador->nombre_completo
                    ];
                }

                $sancion                  = new Sancion();
                $sancion->usuario_id      = $data['usuario_id'];
                $sancion->trabajador_id   = $trabajador_id;
                $sancion->regimen_id      = $regimen_id;
                $sancion->zona_labor_id   = $zona_labor_id;
                $sancion->oficio_id       = $ofico_id;
                $sancion->cuartel_id      = $cuartel_id;
                $sancion->fecha_solicitud = $data['fecha_solicitud'];
            } else {
                $sancion = Sancion::find($data['id']);
            }

            $sancion->fecha_incidencia = $data['fecha_incidencia'];
            $sancion->empresa_id         = $data['empresa_id'];
            $sancion->incidencia_id   = $data['incidencia_id'];

            if ( $data['incidencia_id'] == 2 ) {
                $sancion->fecha_salida = Carbon::parse($data['fecha_incidencia'])->addDay();
                $sancion->fecha_regreso = Carbon::parse($data['fecha_incidencia'])->addDays(3);
                $sancion->total_horas = 16;
            }

            if ( $sancion->save() ) {
                DB::commit();
                return [
                    'error'   => false,
                    'message' => 'Sanción ' . (isset($data['id']) ? 'actualizada' : 'creada') . ' correctamente',
                    'id'      => $sancion->id
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
}
