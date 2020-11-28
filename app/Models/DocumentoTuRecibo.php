<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DocumentoTuRecibo extends Model
{
    protected $table = 'documentos_turecibo';
    public $timestamps = false;

    public static function _getByTrabajador($tipo_documento_turecibo_id, $rut)
    {
        return DB::table('documentos_turecibo as dt')
            ->select(
                'dt.id as key',
                'dt.id',
                'dt.mes',
                'dt.ano',
                'dt.estado',
                'dt.fecha_carga',
                'dt.fecha_firma',
                'e.shortname as empresa',
                're.name as regimen',
                'td.name as tipo_documento'
            )
            ->join('empresas as e', 'e.id', '=', 'dt.empresa_id')
            ->join('regimenes as re', 're.id', '=', 'dt.regimen_id')
            ->join('tipo_documentos_turecibo as td', 'td.id', '=', 'dt.tipo_documento_turecibo_id')
            ->where('dt.rut', $rut)
            ->where('dt.tipo_documento_turecibo_id', $tipo_documento_turecibo_id)
            ->get();
    }

    public static function _get($tipo_documento_turecibo_id, $estado, $empresa_id, $regimen_id, $zona_labor_id)
    {
        $zona_labor = ZonaLabor::where([
            'code' => $zona_labor_id,
            'empresa_id' => $empresa_id
        ])->first();

        $result = DB::table('documentos_turecibo as dt')
            ->select(
                'dt.id as key',
                'dt.id',
                'e.shortname as empresa',
                DB::raw('CONCAT(dt.mes, "-", dt.ano) as periodo'),
                'dt.rut',
                DB::raw('CONCAT(dt.apellido_paterno, " ", dt.apellido_materno, " ", dt.nombre) as nombre_completo'),
                're.name as regimen',
                'dt.estado',
                'z.name as zona_labor'
            )
            ->join('empresas as e', 'e.id', '=', 'dt.empresa_id')
            ->join('regimenes as re', 're.id', '=', 'dt.regimen_id')
            ->leftJoin('zona_labores as z', 'z.id', '=', 'dt.zona_labor_id')
            ->where('dt.estado', $estado)
            ->where('dt.tipo_documento_turecibo_id', $tipo_documento_turecibo_id)
            ->where('dt.empresa_id', $empresa_id)
            ->where('dt.regimen_id', $regimen_id)
            ->when($zona_labor !== null, function($query) use ($zona_labor) {
                $query->where('dt.zona_labor_id', $zona_labor->id);
            })
            ->orderBy('periodo', 'DESC')
            ->orderBy('nombre_completo', 'ASC')
            ->get();

        $result->transform(function ($item) {
            $contratoActual = DB::connection('sqlsrv')->table('dbo.Contratos as c')
                ->select('o.Descripcion as oficio')
                ->join('dbo.Oficio as o', [
                    'o.IdEmpresa' => 'c.IdEmpresa',
                    'o.IdOficio' => 'c.IdOficio'
                ])
                ->where('c.IndicadorVigencia', true)
                ->where('c.RutTrabajador', $item->rut)
                ->whereIn('c.IdEmpresa', [9, 14])
                ->first();

            $item->oficio = $contratoActual->oficio;

            return $item;
        });

        return $result;
    }

    public static function massiveCreate($usuario_id, $empresa_id, $tipo_documento_turecibo_id, array $documentos)
    {
        $count = 0;
        $total = sizeof($documentos);
        $errors = [];

        $corte = new CorteDocumentoTurecibo();
        $corte->fecha_hora_corte = now()->toDateTimeString();
        $corte->empresa_id = $empresa_id;
        $corte->usuario_id = $usuario_id;
        $corte->save();

        foreach ($documentos as $documento)
        {
            try {
                DB::table('documentos_turecibo')->updateOrInsert(
                    [
                        'rut' => $documento['rut'],
                        'ano' => $documento['ano'],
                        'mes' => $documento['mes'],
                        'empresa_id' => $empresa_id,
                        'tipo_documento_turecibo_id' => $tipo_documento_turecibo_id,
                    ],
                    [
                        'nombre' => $documento['nombre'],
                        'apellido_paterno' => $documento['apellido_paterno'],
                        'apellido_materno' => $documento['apellido_materno'],
                        'estado' => $documento['estado'],
                        'fecha_carga' => DateTime::createFromFormat('d/m/Y H:i', $documento['fecha_carga']),
                        'fecha_firma' => isset($documento['fecha_firma']) ? DateTime::createFromFormat('d/m/Y H:i', $documento['fecha_firma']) : null,
                        'regimen_id' => $documento['regimen_id'],
                        'zona_labor_id' => isset($documento['zona_labor_id']) ? $documento['zona_labor_id'] : null,
                        'corte_turecibo_id' => $corte->id
                    ]
                );

                $count++;
            } catch (\Exception $e) {
                array_push($errors, [
                    'id' => $documento['rut'],
                    'error' => $e->getMessage()
                ]);
            }
        }

        $corte->cantidad = $total;
        $corte->errores = json_encode($errors);
        $corte->save();

        return [
            'total' => $total,
            'completados' => $count,
            'errores' => $errors,
        ];
    }

    public static function getCantidadFirmadosPorDia($tipo_documento_turecibo_id, $desde, $hasta, $empresa_id, $regimen_id, $zona_labor_id, $periodo)
    {
        /*
        $result = DB::select('CALL obtener_cantidad_firmados_por_dia(?, ?, ?)', [
            $tipo_documento_turecibo_id,
            $desde,
            $hasta
        ]);*/

        $zona_labor = ZonaLabor::where([
            'code' => $zona_labor_id,
            'empresa_id' => $empresa_id
        ])->first();

        $p= explode('-', $periodo);

        $result = DB::table('documentos_turecibo as dt')
            ->select(
                DB::raw('DATE(dt.fecha_firma) as dia'),
                DB::raw('COUNT(*) as cantidad')
            )
            /*
            ->where('dt.mes', $p[1])
            ->where('dt.ano', $p[0])*/
            ->where('dt.tipo_documento_turecibo_id', $tipo_documento_turecibo_id)
            ->where('dt.estado', 'FIRMADO CONFORME')
            ->where('dt.empresa_id', $empresa_id)
            ->when($regimen_id != 0, function($query) use ($regimen_id) {
                $query->where('dt.regimen_id', $regimen_id);
            })
            ->when($zona_labor !== null, function($query) use ($zona_labor) {
                $query->where('dt.zona_labor_id', $zona_labor->id);
            })
            ->whereNotNull('dt.fecha_firma')
            ->whereDate('dt.fecha_firma', '>=', $desde)
            ->whereDate('dt.fecha_firma', '<=', $hasta)
            ->groupBy('dia')
            ->get()->toArray();

        $dias = array_column($result, 'dia');
        $cantidades = array_column($result, 'cantidad');

        return [
            'dias' => $dias,
            'cantidades' => $cantidades
        ];
    }

    public static function getCantidadPorZonaLabor($periodo, $empresa_id)
    {
        $p= explode('-', $periodo);

        $result = DB::table('documentos_turecibo as dt')
            ->select(
                'zl.id',
                'zl.name as zona_labor',
                DB::raw('count(case dt.estado when \'FIRMADO CONFORME\' then 1 else null end) as firmados'),
                DB::raw('count(case dt.estado when \'NO FIRMADO\' then 1 else null end) as no_firmados'),
                DB::raw('
                    (
		                ROUND( count(case dt.estado when \'FIRMADO CONFORME\' then 1 else null end) * 100 / count(*), 2 )
	                ) as procentaje_firmados
                ')
            )
            ->join('zona_labores as zl', 'zl.id', '=', 'dt.zona_labor_id')
            ->where([
                'mes' => $p[1],
                'ano' => $p[0]
            ])
            ->where('dt.regimen_id',  1)
            ->where('dt.empresa_id', $empresa_id)
            ->orderBy('procentaje_firmados', 'DESC')
            ->groupBy('dt.zona_labor_id')
            ->get();

        return $result;
    }
}
