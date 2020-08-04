<?php

namespace App\Models;

use App\Helpers\DatosHoras;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FormularioPermiso extends Model
{
    protected $table = 'formularios_permisos';

    /**
     * Eloquent Relationships
     */
    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario');
    }

    public function trabajador()
    {
        return $this->belongsTo('App\Models\Trabajador');
    }

    public function jefe()
    {
        return $this->belongsTo('App\Models\Trabajador');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function oficio()
    {
        return $this->belongsTo('App\Models\Oficio');
    }

    public function zona_labor()
    {
        return $this->belongsTo('App\Models\ZonaLabor');
    }

    public function cuartel()
    {
        return $this->belongsTo('App\Models\Cuartel');
    }

    public function motivo_permiso()
    {
        return $this->belongsTo('App\Models\MotivoPermiso');
    }

    public function regimen()
    {
        return $this->belongsTo('App\Models\Regimen');
    }

    /**
     * Attributes
     */
    public function getDiaSalidaAttribute($value)
    {
        return Carbon::parse($this->fecha_hora_salida)->format('d');
    }

    public function getMesSalidaAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_hora_salida);
        return strtoupper($meses[($fecha->format('n')) - 1]);
    }

    public function getAnioSalidaAttribute($value)
    {
        return Carbon::parse($this->fecha_hora_salida)->format('Y');
    }

    public function getDiaRegresoAttribute($value)
    {
        return Carbon::parse($this->fecha_hora_regreso)->format('d');
    }

    public function getMesRegresoAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_hora_regreso);
        return strtoupper($meses[($fecha->format('n')) - 1]);
    }

    public function getAnioRegresoAttribute($value)
    {
        return Carbon::parse($this->fecha_hora_regreso)->format('Y');
    }

    public function getHoraSalidaAttribute($value)
    {
        return Carbon::parse($this->fecha_hora_salida)->format('H:i');
    }

    public function getHoraRegresoAttribute($value)
    {
        return Carbon::parse($this->fecha_hora_regreso)->format('H:i');
    }

    public function getFechaSolicitudFormatAttribute($value)
    {
        return Carbon::parse($this->fecha_solicitud)->format('d/m/Y');
    }

    /**
     * Static methods
     */

    public static function calcularHoras(DatosHoras $datosHoras)
    {
        if ( !$datosHoras->esValido() ) {
            return [
                'error'   => true,
                'message' => 'La fecha y hora de salida es mayor o igual a la fecha de regreso',
                'horas'   => 0
            ];
        }

        if ( !$datosHoras->verificarHoras() ) {
            return [
                'error'   => true,
                'message' => 'Las horas de del permiso no esta en el horario de entrada y salida',
                'horas'   => 0
            ];
        }

        $dias = $datosHoras->getDias();
        $horas = $datosHoras->getHoras();
        $total_horas = $datosHoras->getTotalHoras();

        return [
            'message'     => $total_horas . ' horas de permiso',
            'dias'        => $dias,
            'horas'       => $horas,
            'total_horas' => $total_horas,
        ];
    }

    public static function _getAll(int $usuario_id, array $fechas, int $estado=0)
    {
        $usuario = Usuario::find($usuario_id);

        if ( !$usuario ) {
            return [
                'error' => true,
                'message' => 'No se encontro el usuario'
            ];
        }

        if ( $usuario->permisos == 1 ) {
            return [];
        } else if ( $usuario->permisos == 2 ) {
            return [];
        } else {
            return [];
        }
    }

    public static function _create(array $data)
    {
        DB::beginTransaction();
        try {
            $motivo_permiso_id = MotivoPermiso::findOrCreate($data['motivo_permiso']);
            $jefe_id           = Trabajador::findOrCreate($data['jefe']);

            if ( !isset($data['id']) ) {
                $trabajador_id     = Trabajador::findOrCreate($data['trabajador']);
                $regimen_id        = Regimen::findOrCreate($data['regimen']);
                $zona_labor_id     = ZonaLabor::findOrCreate($data['zona_labor']);
                $ofico_id          = Oficio::findOrCreate($data['oficio']);
                $cuartel_id        = Cuartel::findOrCreate($data['cuartel'], $zona_labor_id);

                // TODO: Comentado temporalmente para pruebas
                /*
                $existe_registro_mismo_dia = FormularioPermiso::where([
                    'fecha_solicitud' => $data['fecha_solicitud'],
                    'trabajador_id'   => $trabajador_id,
                ])->first();

                if ( $existe_registro_mismo_dia ) {
                    DB::rollBack();
                    return [
                        'error' => 'Ya existe un formulario para el ' . $data['fecha_solicitud'] . '<br />USUARIO: ' . $existe_registro_mismo_dia->usuario->trabajador->nombre_completo
                    ];
                }*/

                $form = new FormularioPermiso();
                $form->usuario_id    = $data['usuario_id'];
                $form->trabajador_id = $trabajador_id;
                $form->regimen_id    = $regimen_id;
                $form->zona_labor_id = $zona_labor_id;
                $form->oficio_id     = $ofico_id;
                $form->cuartel_id    = $cuartel_id;
                $form->fecha_solicitud = $data['fecha_solicitud'];

                $form->fecha_hora_salida = date($data['fecha_salida'] . ' ' . $data['hora_salida']);
                $form->fecha_hora_regreso = date($data['fecha_regreso'] . ' ' . $data['hora_regreso']);
                $form->refrigerio = $data['refrigerio'];
                $form->total_horas = $data['total_horas'];
                $form->observacion = $data['observacion'];
                $form->jefe_id = $jefe_id;
                $form->empresa_id = $data['empresa_id'];
                $form->motivo_permiso_id = $motivo_permiso_id;
            } else {
                $form                     = FormularioPermiso::find($data['id']);
                $form->fecha_hora_salida  = date($data['fecha_salida'] . ' ' . $data['hora_salida']);
                $form->fecha_hora_regreso = date($data['fecha_regreso'] . ' ' . $data['hora_regreso']);
                $form->refrigerio         = $data['refrigerio'];
                $form->total_horas        = $data['total_horas'];
                $form->observacion        = $data['observacion'];
                $form->jefe_id            = $jefe_id;
                $form->empresa_id         = $data['empresa_id'];
                $form->motivo_permiso_id  = $motivo_permiso_id;
            }

            if ( $form->save() ) {
                DB::commit();
                return [
                    'error'   => false,
                    'message' => 'Formulario creado correctamente',
                    'id'      => $form->id
                ];
            }

            DB::rollBack();
            return 0;
        } catch(\Exception $e) {
            DB::rollBack();
            return [
                'error'   => true,
                'message' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }
}
