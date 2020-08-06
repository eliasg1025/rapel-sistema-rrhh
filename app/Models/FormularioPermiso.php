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

    public static function _show()
    {
        return DB::table('formularios_permisos as f')
            ->select(
                'f.id',
                'f.fecha_solicitud',
                'c.empresa_id',
                DB::raw('CONCAT(t.apellido_paterno, " ", t.apellido_materno, " ", t.nombre) as nombre_trabajador'),

            )
            ->join('trabajadores as t ', 't.id', '=', 'f.trabajador_id')
            ->get();
    }

    public static function calcularHoras(DatosHoras $datosHoras)
    {
        if ( !$datosHoras->esValido() ) {
            return [
                'error'   => true,
                'message' => 'La fecha y hora de salida es mayor a la fecha de regreso',
                'horas'   => 0
            ];
        }

        if ( !$datosHoras->verificarHoras() ) {
            return [
                'error'   => true,
                'message' => 'Las horas del permiso no están dentro horario asignado',
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
            return DB::table('formularios_permisos as f')
                ->select(
                    'f.id',
                    DB::raw('DATE_FORMAT(f.fecha_solicitud, "%d/%m/%Y") fecha_solicitud'),
                    DB::raw('DATE_FORMAT(f.created_at, "%H:%i:%s") hora'),
                    't.rut',
                    't.code',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                    DB::raw('DATE_FORMAT(f.fecha_hora_salida, "%d/%m/%Y") fecha_salida'),
                    DB::raw('DATE_FORMAT(f.fecha_hora_regreso, "%d/%m/%Y") fecha_regreso'),
                    'm.code as motivo_permiso_id',
                    'm.name as motivo_permiso',
                    'z.code as zona_labor_id',
                    'z.name as zona_labor',
                    'f.total_horas as horas',
                    'f.goce',
                    DB::raw('DATE_FORMAT(f.fecha_hora_salida, "%H:%i") hora_salida'),
                    DB::raw('DATE_FORMAT(f.fecha_hora_regreso, "%H:%i") hora_regreso'),
                    'e.shortname as empresa',
                    DB::raw('CONCAT(j.nombre, " ", j.apellido_paterno, " ", j.apellido_materno) as nombre_completo_jefe'),
                    'f.estado'
                )
                ->join('trabajadores as t', 't.id', '=', 'f.trabajador_id')
                ->join('trabajadores as j', 'j.id', '=', 'f.jefe_id')
                ->join('empresas as e', 'e.id', '=', 'f.empresa_id')
                ->join('motivos_permisos as m', 'm.id', '=', 'f.motivo_permiso_id')
                ->join('zona_labores as z', 'z.id', '=', 'f.zona_labor_id')
                ->where('f.usuario_id', $usuario->id)
                ->where('f.estado', $estado)
                ->whereBetween('f.fecha_solicitud', [$fechas['desde'], $fechas['hasta']])
                ->orderBy('f.id', 'ASC')
                ->get();
        } else if ( $usuario->permisos == 2 ) {
            $usuarios = DB::table('usuarios as u')
                ->select(
                    'u.id',
                    'u.username',
                    DB::raw('CONCAT(t.apellido_paterno, " ", t.apellido_materno, " ", t.nombre) as nombre_completo_usuario')
                )
                ->join('trabajadores as t', 't.id', '=', 'u.trabajador_id');

            return DB::table('formularios_permisos as f')
                ->select(
                    'f.id',
                    'f.fecha_solicitud',
                    DB::raw('DATE_FORMAT(f.created_at, "%H:%i:%s") hora'),
                    't.rut',
                    't.code',
                    DB::raw('CONCAT(t.nombre, " ", t.apellido_paterno, " ", t.apellido_materno) as nombre_completo'),
                    DB::raw('DATE_FORMAT(f.fecha_hora_salida, "%d/%m/%Y") fecha_salida'),
                    DB::raw('DATE_FORMAT(f.fecha_hora_regreso, "%d/%m/%Y") fecha_regreso'),
                    'm.code as motivo_permiso_id',
                    'm.name as motivo_permiso',
                    'z.code as zona_labor_id',
                    'z.name as zona_labor',
                    'f.total_horas as horas',
                    'f.goce',
                    DB::raw('DATE_FORMAT(f.fecha_hora_salida, "%H:%i") hora_salida'),
                    DB::raw('DATE_FORMAT(f.fecha_hora_regreso, "%H:%i") hora_regreso'),
                    'e.shortname as empresa',
                    DB::raw('CONCAT(j.nombre, " ", j.apellido_paterno, " ", j.apellido_materno) as nombre_completo_jefe'),
                    'f.estado',
                    'usuario.username as usuario',
                    'usuario.nombre_completo_usuario as nombre_completo_usuario',
                )
                ->join('trabajadores as t', 't.id', '=', 'f.trabajador_id')
                ->join('trabajadores as j', 'j.id', '=', 'f.jefe_id')
                ->join('empresas as e', 'e.id', '=', 'f.empresa_id')
                ->join('motivos_permisos as m', 'm.id', '=', 'f.motivo_permiso_id')
                ->join('zona_labores as z', 'z.id', '=', 'f.zona_labor_id')
                ->joinSub($usuarios, 'usuario', function($join) {
                    $join->on('usuario.id', '=', 'f.usuario_id');
                })
                ->where('f.estado', $estado)
                ->whereBetween('f.fecha_solicitud', [$fechas['desde'], $fechas['hasta']])
                ->orderBy('f.id', 'ASC')
                ->get();
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

                if ( $data['total_horas'] <= 0 ) {
                    DB::rollBack();
                    return [
                        'error' => 'La cantidad de horas de permiso debe ser mayor a 0'
                    ];
                }

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

    public static function marcarFirmado(int $usuario_id, int $id)
    {
        $formularioPermiso = FormularioPermiso::find($id);
        $usuario = Usuario::find($usuario_id);

        if ( $usuario->id !== $formularioPermiso->usuario_id ) {
            return [
                'error'   => true,
                'message' => 'La misma persona que cargó este formulario debe marcarlo como firmado'
            ];
        }

        $formularioPermiso->estado = 1;
        if ( $formularioPermiso->save() ) {
            return [
                'message' => 'Formulario enviado correctamente'
            ];
        }

        return [
            'error'   => true,
            'message' => 'No se pudo resolver esta operación'
        ];
    }

    public static function marcarCargado(int $usuario_id, int $id)
    {
        $formularioPermiso = FormularioPermiso::find($id);
        $usuario = Usuario::find($usuario_id);

        if ( $usuario->permisos < 2 ) {
            return [
                'error'   => true,
                'message' => 'Solo un usuario administrador puede marcar este formulario como CARGADO'
            ];
        }

        $formularioPermiso->estado = 2;
        if ( $formularioPermiso->save() ) {
            return [
                'message' => 'Formulario actualizado correctamente'
            ];
        }

        return [
            'error'   => true,
            'message' => 'No se pudo resolver esta operación'
        ];
    }
}
