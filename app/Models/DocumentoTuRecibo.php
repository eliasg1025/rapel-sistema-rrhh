<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DocumentoTuRecibo extends Model
{
    protected $table = 'documentos_turecibo';

    public static function _get($tipo_documento_turecibo_id, $estado_documento_turecibo_id = 1)
    {
        $result = DB::table('documentos_turecibo as dt')
            ->select(
                'dt.id as key',
                'dt.id',
                'e.shortname as empresa',
                DB::raw('CONCAT(dt.mes, "-", dt.ano) as periodo'),
                DB::raw('CONCAT(dt.apellido_paterno, " ", dt.apellido_materno, " ", dt.nombre) as nombre_completo'),
                're.name as regimen',
                'edt.name as estado'
            )
            ->join('empresas as e', 'e.id', '=', 'dt.empresa_id')
            ->join('regimenes as re', 're.id', '=', 'dt.regimen_id')
            ->join('estado_documentos_turecibo as edt', 'edt.id', '=', 'dt.estado_documento_turecibo_id')
            ->where('dt.estado_documento_turecibo_id', $estado_documento_turecibo_id)
            ->where('dt.tipo_documento_turecibo_id', $tipo_documento_turecibo_id)
            ->get();

        return $result;
    }
}
