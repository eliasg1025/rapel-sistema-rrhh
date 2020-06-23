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
        $registrados = $data['registrados'];
        $guardados = [];
        foreach($registrados as $registrado) {
            $is_save = self::record($registrado);
            if ( $is_save ) {
                array_push($guardados, [
                    'rut' => $is_save
                ]);
            }
        }

        return [
            'guardados' => $guardados
        ];
    }

    public static function record(array $data=[])
    {
        DB::beginTransaction();
        try {
            $zona_labor = ZonaLabor::where([
                'code' => $data['contrato']['zona_labor_id'],
                'empresa_id' => $data['contrato']['empresa_id']
            ])->first();

            $contrato = new Contrato();
            $contrato->editable = true;
            $contrato->cargado = false;
            $contrato->activo = true;
            $contrato->fecha_inicio = $data['contrato']['fecha_ingreso'];
            $contrato->fecha_termino_c = $data['contrato']['fecha_termino'];
            $contrato->empresa_id = $data['contrato']['empresa_id'];
            $contrato->group = $data['contrato']['grupo'];
            $contrato->codigo_bus = $data['contrato']['codigo_bus'];
            $contrato->zona_labor_id = $zona_labor->id;
            $contrato->trabajador_id = Trabajador::findOrCreate($data);
            if ($contrato->save()) {
                DB::commit();
                return $data['rut'];
            }

            DB::rollBack();
            return false;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public static function generate_pdf(array $data=[])
    {
        try {
            foreach ($data as $d) {
                $contrato = Contrato::find($d['contrato_id']);
                $trabajador = $contrato->trabajador;

                $data = [
                    'trabajador' => $trabajador,
                    'contrato' => $contrato
                ];

                $content = \PDF::setOptions([
                    'images' => true
                ])->loadView('fichas-ingresos-obreros.rapel.contrato', $data)->output();

                $filename = Carbon::parse(Carbon::now())->format('Y-m-d') . '/' . time() . '-' .$trabajador->apellido_paterno . '_' . $trabajador->nombre  .'-CONTRATO.pdf';

                \Storage::disk('public')->put($filename, $content);
            }

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
