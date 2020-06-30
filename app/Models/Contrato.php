<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contrato extends Model
{
    protected $table = 'contratos';

    public function trabajador()
    {
        return $this->belongsTo('App\Models\Trabajador');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    /**
     * Mutators
     */

    public function getFechaLargaAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_inicio);
        $mes = $meses[($fecha->format('n')) - 1];
        return $fecha->format('d') . ' de ' . $mes . ' de ' . $fecha->format('Y');
    }

    public function getAnioContratoAttribute($value)
    {
        return Carbon::parse($this->fecha_inicio)->format('Y');
    }

    public function getMesContratoAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_inicio);
        $mes = $meses[($fecha->format('n')) - 1];
        return $mes;
    }

    public function getFechaFormatAttribute($value)
    {
        return Carbon::parse($this->fecha_inicio)->format('d/m/Y');
    }

    /**
     * CRUD methods
     */

    public static function _save(array $data): bool
    {
        try {
            $contrato = Contrato::firstWhere([
                'code' => $data['code'],
                'fecha_inicio' => $data['fecha_inicio'],
                'fecha_termino_c' => $data['fecha_termino_c'],
            ]);

            if (!$contrato) {
                $contrato = new Contrato();
                $contrato->code = $data['code'];
                $contrato->fecha_inicio = $data['fecha_inicio'];
                $contrato->fecha_termino_c = $data['fecha_termino_c'];
            }

            $contrato->fecha_termino = $data['fecha_termino'] ?? null;
            $contrato->sueldo_base = $data['sueldo_base'];
            $contrato->cussp = $data['cussp'];
            $contrato->trabajador_id = $data['trabajador_id'];
            $contrato->empresa_id = $data['empresa_id'];
            $contrato->zona_labor_id = $data['zona_labor_id'];

            if ($contrato->save()) {
                return true;
            }
            return false;

        } catch (\Exception $e) {
            return false;
        }
    }

    public static function masive_save(array $data): bool
    {
        $contratos = $data['contratos'];
        DB::beginTransaction();
        try {
            for ($i=0; $i < sizeof($contratos); $i++) {

                $fecha_inicio = Carbon::parse($contratos[$i]['fecha_inicio'])->format('Y-m-d');
                $fecha_termino_c = $contratos[$i]['fecha_termino_c'] ? Carbon::parse($contratos[$i]['fecha_termino_c'])->format('Y-m-d') : null;
                $fecha_termino = $contratos[$i]['fecha_termino'] ? Carbon::parse($contratos[$i]['fecha_termino'])->format('Y-m-d') : null;

                $contrato = self::where([
                    'code' => $contratos[$i]['code'],
                    'empresa_id' => $data['empresa_id'],
                    'trabajador_id' => $data['trabajador_id'],
                ])->first();

                if (!$contrato) {
                    $contrato = new Contrato();
                    $contrato->code = $contratos[$i]['code'];
                    $contrato->empresa_id = $data['empresa_id'];
                    $contrato->trabajador_id = $data['trabajador_id'];
                }

                $contrato->fecha_inicio = $fecha_inicio;
                $contrato->fecha_termino_c = $fecha_termino_c;
                $contrato->fecha_termino = $fecha_termino;
                $contrato->sueldo_base = $contratos[$i]['sueldo_base'];
                $contrato->cussp = $contratos[$i]['cussp'];
                $contrato->zona_labor_id = $data['zona_labor_id'];

                if (!$contrato->save()) {
                    DB::rollBack();
                    return false;
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function massive_record(array $data=[])
    {
        try {
            $registrados = $data['registrados'];
            $guardados = [];
            $errores = [];

            foreach($registrados as $registrado) {
                $is_save = self::record($registrado);
                if ( !$is_save['error'] ) {
                    array_push($guardados, [
                        'rut' => $is_save['rut'],
                        'observado' => $is_save['observado']
                    ]);
                } else {
                    array_push($errores, [
                        'rut' => $is_save['rut'],
                        'error' => $is_save['error']
                    ]);
                }
            }

            return [
                'guardados' => $guardados,
                'errores' => $errores
            ];
        } catch (\Exception $e) {
            return [
                'errores' => [$e->getMessage()]
            ];
        }
    }

    public static function record(array $data=[])
    {
        DB::beginTransaction();
        try {
            $contrato_data = $data['contrato'];

            $zona_labor = ZonaLabor::where([
                'code' => $contrato_data['zona_labor_id'],
                'empresa_id' => $contrato_data['empresa_id']
            ])->first();

            $trabajador_id = Trabajador::findOrCreate($data);
            $oficio_id = Oficio::findOrCreate($contrato_data['oficio']);
            $regimen_id = Regimen::findOrCreate($contrato_data['regimen']);
            $actividad_id = Actividad::findOrCreate($contrato_data['actividad']);
            $agrupacion_id = Agrupacion::findOrCreate($contrato_data['agrupacion']);
            $cuartel_id = Cuartel::findOrCreate($contrato_data['cuartel'], $zona_labor->id);
            $tipo_contrato_id = TipoContrato::findOrCreate($contrato_data['tipo_contrato']);
            $labor_id = Labor::findOrCreate($contrato_data['labor'], $actividad_id);

            $contrato_activo = $data['contrato_activo'] ?? [];
            $alertas = $data['alertas'] ?? [];

            $existe_contrato = Contrato::where([
                'trabajador_id' => $trabajador_id,
                'fecha_inicio'  =>  $contrato_data['fecha_ingreso'],
            ])->exists();

            if ($existe_contrato) {
                DB::rollBack();
                return [
                    'rut' => $data['rut'],
                    'error' => 'Ya existe un contrato generado con fecha de ingreso ' . $contrato_data['fecha_ingreso']
                ];
            }

            $observado = false;
            if (sizeof($contrato_activo) > 0) {
                Observacion::where([
                    'contrato_activo' => true,
                    'trabajador_id'   => $trabajador_id
                ])->delete();
                $observacion = new Observacion();
                $observacion->observacion = 'Ya hay contrato activo en el sistema: ' . $data['contrato_activo'][0]['contrato_id'];
                $observacion->contrato_activo = true;
                $observacion->fecha_inicio = $data['contrato_activo'][0]['fecha_inicio'] ?? null;
                $observacion->fecha_termino_c = $data['contrato_activo'][0]['fecha_termino_c'] ?? null;
                $observacion->zona_labor_id = $data['contrato_activo'][0]['zona_id'];
                $observacion->empresa_id = $data['contrato_activo'][0]['empresa_id'];
                $observacion->trabajador_id = $trabajador_id;
                $observacion->save();

                $observado = true;
            }

            if (sizeof($alertas) > 0) {
                foreach ($alertas as $data) {
                    $alerta = new Observacion();
                    $alerta->contrato_activo = false;
                    $alerta->empresa_id = $data['empresa_id'];
                    $alerta->digito = $data['digito'] ?? null;
                    $alerta->observacion = $data['observacion'];
                    $alerta->fecha = $data['fecha'] ?? null;
                    $alerta->zona_labor_id = $data['zona_id'] ?? null;
                    $alerta->trabajador_id = $trabajador_id;
                    $alerta->save();
                }

                $observado = true;
            }

            if ($observado) {
                $trabajador = Trabajador::whereRut($data['rut'])->first();
                $trabajador->observado = true;
                $trabajador->save();
            }

            $contrato = new Contrato();
            $contrato->editable = true;
            $contrato->cargado = false;
            $contrato->activo = true;
            $contrato->fecha_inicio = $contrato_data['fecha_ingreso'];
            $contrato->fecha_termino_c = $contrato_data['fecha_termino'];
            $contrato->empresa_id = $contrato_data['empresa_id'];
            $contrato->group = $contrato_data['grupo'];
            $contrato->codigo_bus = $contrato_data['codigo_bus'];
            $contrato->zona_labor_id = $zona_labor->id;
            $contrato->trabajador_id = $trabajador_id;
            $contrato->oficio_id = $oficio_id;
            $contrato->regimen_id = $regimen_id;
            $contrato->actividad_id = $actividad_id;
            $contrato->agrupacion_id = $agrupacion_id;
            $contrato->tipo_contrato_id = $tipo_contrato_id;
            $contrato->cuartel_id = $cuartel_id;
            $contrato->labor_id = $labor_id;
            if ( $contrato->save() ) {
                DB::commit();
                return [
                    'rut'      => $data['rut'],
                    'observado' => $observado,
                    'error'    => false
                ];
            }

            DB::rollBack();
            return [
                'rut' => $data['rut'],
                'error' => true
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'rut' => $data['rut'],
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }
}
