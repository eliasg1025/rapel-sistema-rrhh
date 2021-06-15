<?php

namespace App\Models\Sqlsrv;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contrato extends Model
{
    protected $connection = 'sqlsrv';

    protected $table = 'dbo.Contratos';

    public $incrementing = false;

    public function zona_labor()
    {
        return $this->belongsTo('App\Models\ZonaLabor');
    }

    public static function activo($rut, $activo=true, $info_jornal=false)
    {
        $where = $activo ? [
            'RutTrabajador' => $rut,
            'IndicadorVigencia' => '1'
        ] : ['RutTrabajador' => $rut];

        $contratos = self::where($where)
            ->select(
                'IdContrato as contrato_id',
                'IdTrabajador as trabajador_code',
                'IdEmpresa as empresa_id',
                'FechaInicioPeriodo as fecha_inicio',
                'IdZona as zona_id',
                'Jornal as jornal',
                'FechaTerminoC as fecha_termino_c',
                'IdAfp as afp_id',
                'IdOficio as oficio_id',
                'IdCuartel as cuartel_id',
                'IdRegimen as regimen_id',
                DB::raw('
                    CASE
                        WHEN IdRegimen = 2
                            THEN CAST(ROUND(SueldoBase, 2, 0) as decimal(18, 2))
                        WHEN IdRegimen = 3
                            THEN CAST(ROUND((SueldoBase * 1.2638 * 30), 2, 0) as decimal(18, 2))
                        ELSE
                            CAST(ROUND((SueldoBase * 1.2638) + BONO_LABOR, 2, 0) as decimal(18, 2))
                    END AS sueldo_bruto
                '),
            )
            ->orderBy('FechaInicio', 'DESC')
            ->get();

        if ($info_jornal == false) {
            return $contratos;
        }

        return $contratos;
    }
}
