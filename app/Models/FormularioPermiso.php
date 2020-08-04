<?php

namespace App\Models;

use App\Helpers\DatosHoras;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FormularioPermiso extends Model
{
    protected $table = 'formularios_permisos';

    public function usuario()
    {
        return $this->belongsTo('App\Models\Usuario');
    }

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

    public static function _create(array $data)
    {
        DB::beginTransaction();
        try {
            $motivo_permiso_id = MotivoPermiso::findOrCreate($data['motivo_permiso']);
            $jefe_id           = Trabajador::findOrCreate($data['jefe']);

            if ( !isset($data['id']) ) {
                $trabajador_id     = Trabajador::findOrCreate($data['trabajador']);
                $zona_labor_id     = ZonaLabor::findOrCreate($data['zona_labor']);
                $ofico_id          = Oficio::findOrCreate($data['oficio']);
                $cuartel_id        = Cuartel::findOrCreate($data['cuartel'], $zona_labor_id);

                $existe_registro_mismo_dia = FormularioPermiso::where([
                    'fecha_solicitud' => $data['fecha_solicitud'],
                    'trabajador_id'   => $trabajador_id,
                ])->first();

                if ( $existe_registro_mismo_dia ) {
                    DB::rollBack();
                    return [
                        'error' => 'Ya existe un formulario para el ' . $data['fecha_solicitud'] . '<br />USUARIO: ' . $existe_registro_mismo_dia->usuario->trabajador->nombre_completo
                    ];
                }

                $form = new FormularioPermiso();
                $form->usuario_id = $data['usuario_id'];
                $form->trabajador_id = $trabajador_id;
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
                    'error'                 => false,
                    'message'               => 'Registro creado correctamente',
                    'formulario_permiso_id' => $form->id
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
