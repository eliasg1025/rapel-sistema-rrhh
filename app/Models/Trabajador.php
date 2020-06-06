<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Trabajador extends Model
{
    protected $table = 'trabajadores';

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function zona_labor()
    {
        return $this->belongsTo('App\Models\ZonaLabor');
    }

    public function distrito()
    {
        return $this->belongsTo('App\Models\Distrito');
    }

    public function contratos()
    {
        return $this->hasMany('App\Models\Contrato');
    }

    /**
     * Mutators
     */

    public function getApellidosAttribute($value)
    {
        return $this->apellido_paterno . ' ' . $this->apellido_materno;
    }

    public function getNombreCompletoAttribute($value)
    {
        return $this->nombre . ' ' . $this->apellidos;
    }

    public function getFechaFormatAttribute($value)
    {
        return  Carbon::parse($this->fecha_nacimiento)->format('d/m/Y');
    }

    /**
     * CRUD static methods
     */

    public static function _save(array $data=[])
    {
        $empresa_id = Empresa::firstWhere('code', $data['empresa_id'])->id;
        $distrito_id = Distrito::firstWhere('code', $data['distrito_id'])->id;
        $estado_civil_id = EstadoCivil::firstWhere('code', $data['estado_civil_id'])->id;
        $tipo_zona_id = $data['tipo_zona_id'] ? Zona::firstWhere(['code' => $data['tipo_zona_id'],'empresa_id' => $empresa_id])->id : null;
        $tipo_via_id = $data['tipo_via_id'] ? Via::firstWhere(['code' => $data['tipo_via_id'],'empresa_id' => $empresa_id])->id : null;
        $nacionalidad_id = Nacionalidad::firstWhere(['code' => $data['nacionalidad_id'],'empresa_id' => $empresa_id])->id;
        $zona_labor_id = ZonaLabor::firstWhere(['code' => $data['zona_labor_id'],'empresa_id' => $empresa_id])->id;

        $trabajador_id = self::where(['rut' => $data['rut'], 'empresa_id' => $empresa_id])->first();

        DB::beginTransaction();
        try {
            $trabajador = Trabajador::firstOrNew([
                'rut' => $data['rut'],
                'empresa_id' => $empresa_id,
            ]);

            $trabajador->nombre = $data['nombre'];
            $trabajador->apellido_paterno = $data['apellido_paterno'];
            $trabajador->apellido_materno = $data['apellido_materno'];
            $trabajador->fecha_nacimiento = $data['fecha_nacimiento'];
            $trabajador->tipo = $data['tipo'];
            $trabajador->codigo_bus = $data['codigo_bus'];
            $trabajador->sexo = $data['sexo'];
            $trabajador->telefono = $data['telefono'];
            $trabajador->email = $data['email'];
            $trabajador->tipo_zona_id = $tipo_zona_id;
            $trabajador->nombre_zona = $data['nombre_zona'];
            $trabajador->tipo_via_id = $tipo_via_id;
            $trabajador->nombre_via = $data['nombre_via'];
            $trabajador->direccion = $data['direccion'];
            $trabajador->distrito_id = $distrito_id;
            $trabajador->estado_civil_id = $estado_civil_id;
            $trabajador->nacionalidad_id = $nacionalidad_id;
            $trabajador->ruta_id = $data['ruta_id'] ? $data['ruta_id'] : null;
            $trabajador->zona_labor_id = $zona_labor_id;

            if ($trabajador->save()) {
                DB::commit();
                return true;

            } else {
                throw new \Exception();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            var_dump($e);
            return false;
        }

        /*
        if (!$trabajador_id) {
            $trabajador = new Trabajador();
            $trabajador->rut = $data['rut'];
            $trabajador->empresa_id = $empresa_id;
            $trabajador->nombre = $data['nombre'];
            $trabajador->apellido_paterno = $data['apellido_paterno'];
            $trabajador->apellido_materno = $data['apellido_materno'];
            $trabajador->fecha_nacimiento = $data['fecha_nacimiento'];
            $trabajador->tipo = $data['tipo'];
            $trabajador->codigo_bus = $data['codigo_bus'];
            $trabajador->sexo = $data['sexo'];
            $trabajador->telefono = $data['telefono'];
            $trabajador->email = $data['email'];
            $trabajador->tipo_zona_id = $tipo_zona_id;
            $trabajador->nombre_zona = $data['nombre_zona'];
            $trabajador->tipo_via_id = $tipo_via_id;
            $trabajador->nombre_via = $data['nombre_via'];
            $trabajador->direccion = $data['direccion'];
            $trabajador->distrito_id = $distrito_id;
            $trabajador->estado_civil_id = $estado_civil_id;
            $trabajador->nacionalidad_id = $nacionalidad_id;
            $trabajador->ruta_id = $data['ruta_id'] ? $data['ruta_id'] : null;
            $trabajador->zona_labor_id = $zona_labor_id;

            if ($trabajador->save()) {
                Contrato::masive_save($data['contratos']);
                return true;
            }
            return false;

        } else {

            $trabajador = self::where([
                'rut' => $data['rut'],
                'empresa_id' => $empresa_id
            ])->first();

            $trabajador->nombre = $data['nombre'];
            $trabajador->apellido_paterno = $data['apellido_paterno'];
            $trabajador->apellido_materno = $data['apellido_materno'];
            $trabajador->fecha_nacimiento = $data['fecha_nacimiento'];
            $trabajador->tipo = $data['tipo'];
            $trabajador->codigo_bus = $data['codigo_bus'];
            $trabajador->sexo = $data['sexo'];
            $trabajador->telefono = $data['telefono'];
            $trabajador->email = $data['email'];
            $trabajador->tipo_zona_id = $tipo_zona_id;
            $trabajador->nombre_zona = $data['nombre_zona'];
            $trabajador->tipo_via_id = $tipo_via_id;
            $trabajador->nombre_via = $data['nombre_via'];
            $trabajador->direccion = $data['direccion'];
            $trabajador->distrito_id = $distrito_id;
            $trabajador->estado_civil_id = $estado_civil_id;
            $trabajador->nacionalidad_id = $nacionalidad_id;
            $trabajador->ruta_id = $data['ruta_id'] ? $data['ruta_id'] : null;
            $trabajador->zona_labor_id = $zona_labor_id;

            if ($trabajador->save()) {
                Contrato::_create_masive($data['contratos']);
                return true;
            }
            return false;
        }
        */
    }

    public static function _get()
    {
        $trabajadores = DB::table('trabajadores')
            ->join('empresas', 'empresas.id', '=', 'trabajadores.empresa_id')
            ->join('zona_labores', 'zona_labores.id', '=', 'trabajadores.zona_labor_id')
            ->select('trabajadores.*', 'empresas.name as empresa_name', 'empresas.code as empresa_code', 'zona_labores.name as zona_labor_name')
            ->get();

        return $trabajadores;
    }
}
