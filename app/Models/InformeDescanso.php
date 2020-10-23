<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class InformeDescanso extends Model
{
    protected $table = 'informes_descansos_medicos';

    protected $fillable = ['fecha_inicio', 'empresa_id', 'usuario_id'];

    public function registros()
    {
        return $this->hasMany(RegistroDescanso::class, 'informe_descanso_medico_id', 'id');
    }

    public static function obtenerCorrelativo($id, $empresaId, $fechaIncio)
    {
        $anio = Carbon::parse($fechaIncio)->year;

        $ids = DB::table('informes_descansos_medicos')
            ->select('id')
            ->where([
                'empresa_id' => $empresaId,
            ])
            ->whereYear('fecha_inicio', $anio)
            ->orderBy('id')
            ->get()->toArray();

        $result = array_search($id, array_column($ids, 'id')) + 1;

        $desfase = 0;
        if ($anio == 2020 && $empresaId == 9) {
            $desfase = 188;
        } else if ($anio == 2020 && $empresaId == 14) {
            $desfase = 192;
        }

        return 'INFORME N°' . ( $result + $desfase ) . ' - ' . $anio;
    }
}
