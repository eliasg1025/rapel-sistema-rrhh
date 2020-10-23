<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RegistroDescanso extends Model
{
    protected $table = 'registros_descansos_medicos';

    public static function getByInforme($infome_id)
    {
        $result = DB::table('registros_descansos_medicos as rdm')
            ->select(
                'rdm.id',
                't.code',
                't.rut',
                DB::raw("CONCAT(t.nombre, ' ', t.apellido_paterno, ' ', t.apellido_materno) as nombre_completo_trabajador"),
                'tlm.name as contingencia',
                'rdm.tipo_licencia_medica_id',
                'rdm.fecha_inicio',
                'rdm.fecha_fin',
                DB::raw('DATEDIFF(rdm.fecha_fin, rdm.fecha_inicio) + 1 as total_dias'),
                'zl.name as zona_labor',
                'zl.code as zona_labor_id',
                'rdm.trabajador_id',
                'rdm.observacion',
                'rdm.consideracion',
                'rdm.fecha_emision',
                'rdm.numero_registro'
            )
            ->join('trabajadores as t', [
                'rdm.trabajador_id' => 't.id'
            ])
            ->join('informes_descansos_medicos as idm', [
                'idm.id' => 'rdm.informe_descanso_medico_id'
            ])
            ->join('tipo_licencias_medicas as tlm', [
                'tlm.id' => 'rdm.tipo_licencia_medica_id',
                'tlm.empresa_id' => 'idm.empresa_id'
            ])
            ->join('zona_labores as zl', [
                'zl.id' => 'rdm.zona_labor_id'
            ])
            ->where([
                'rdm.informe_descanso_medico_id' => $infome_id
            ])
            ->get();

        return $result;
    }
}
