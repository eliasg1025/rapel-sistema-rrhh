<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    protected $table = 'trabajadores';

    public static function _create(array $data=[]): bool
    {
        $existe_trabajador = self::where([
            'rut' => $data['rut'],
            'empresa_id' => $data['empresa_id']
        ])->exists();

        if (!$existe_trabajador) {

            $trabajador = new Trabajador();
            $trabajador->rut = $data['rut'];
            $trabajador->empresa_id = Empresa::firstWhere('code', $data['empresa_id'])->id;
            $trabajador->nombre = $data['nombre'];
            $trabajador->apellido_paterno = $data['apellido_paterno'];
            $trabajador->apellido_materno = $data['apellido_materno'];
            $trabajador->fecha_nacimiento = $data['fecha_nacimiento'];
            $trabajador->tipo = $data['tipo'];
            $trabajador->codigo_bus = $data['codigo_bus'];
            $trabajador->sexo = $data['sexo'];
            $trabajador->telefono = $data['telefono'];
            $trabajador->email = $data['email'];
            $trabajador->tipo_zona_id =  $data['tipo_zona_id'] ? Zona::firstWhere('code', $data['tipo_zona_id'])->id : null;
            $trabajador->nombre_zona = $data['nombre_zona'];
            $trabajador->tipo_via_id = $data['tipo_via_id'] ? Via::firstWhere('code', $data['tipo_via_id'])->id : null;
            $trabajador->nombre_via = $data['nombre_via'];
            $trabajador->direccion = $data['direccion'];
            $trabajador->distrito_id =  Distrito::firstWhere('code', $data['distrito_id'])->id ;
            $trabajador->estado_civil_id = EstadoCivil::firstWhere('code', $data['estado_civil_id'])->id;
            $trabajador->nacionalidad_id = Nacionalidad::firstWhere('code', $data['nacionalidad_id'])->id;
            $trabajador->ruta_id = $data['ruta_id'];
            $trabajador->zona_labor_id = $data['zona_labor_id'];
            $trabajador->save();

            return true;
        } else {
            return false;
        }
    }
}
