<?php

namespace App\Models;

use App\Services\ReniecService;
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

    public function nacionalidad()
    {
        return $this->belongsTo('App\Models\Nacionalidad');
    }

    public function estado_civil()
    {
        return $this->belongsTo('App\Models\EstadoCivil');
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

    public function getNombreCompletoDocAttribute($value)
    {
        return $this->apellidos . ' ' . $this->nombre;
    }

    public function getFechaFormatAttribute($value)
    {
        return  Carbon::parse($this->fecha_nacimiento)->format('d/m/Y');
    }

    public function getNombreArchivoAttribute($value)
    {
        return $this->apellido_paterno . '-' . $this->apellido_materno . '-' . str_replace(' ', '-', $this->nombre);
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->fecha_nacimiento)->age;
    }

    /**
     * CRUD static methods
     */

    public static function _save(array $data=[])
    {
        $empresa_id = $data['empresa_id'];
        $distrito_id = Distrito::firstWhere('code', $data['distrito_id'])->id;
        $estado_civil_id = EstadoCivil::firstWhere('code', $data['estado_civil_id'])->id;
        $tipo_zona_id = $data['tipo_zona_id'] ? Zona::firstWhere(['code' => $data['tipo_zona_id'],'empresa_id' => $empresa_id])->id : null;
        $tipo_via_id = $data['tipo_via_id'] ? Via::firstWhere(['code' => $data['tipo_via_id'],'empresa_id' => $empresa_id])->id : null;
        $nacionalidad_id = Nacionalidad::firstWhere(['code' => $data['nacionalidad_id'],'empresa_id' => $empresa_id])->id;
        $zona_labor_id = ZonaLabor::firstWhere(['code' => $data['zona_labor_id'],'empresa_id' => $empresa_id])->id;

        DB::beginTransaction();
        try {
            $trabajador = self::where(['rut' => $data['rut'], 'empresa_id' => $empresa_id])->first();

            if (!$trabajador) {
                $trabajador = new Trabajador();
                $trabajador->empresa_id = $empresa_id;
                $trabajador->rut = $data['rut'];
            }

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

            if ($trabajador->save()) {
                DB::commit();
                return true;
                /*
                $contratos_data = [
                    'empresa_id' => $empresa_id,
                    'zona_labor_id' => $zona_labor_id,
                    'trabajador_id' => $trabajador->id,
                    'contratos' => $data['contratos']
                ];

                if ( Contrato::masive_save($contratos_data) ) {
                    DB::commit();
                    return true;
                } else {
                    DB::rollBack();
                    return false;
                }
                */

            } else {
                DB::rollBack();
                return false;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            var_dump($e);
            return false;
        }
    }

    public static function _get(array $filtro=[])
    {
        try {
            $subQuery = DB::table('contratos_has_estados')
                ->select([
                    DB::raw('MAX(created_at) as created_at'),
                    'contrato_id'
                ])
                ->groupBy('contrato_id');

            $subQuery2 = DB::table('contratos_has_estados as pv')
                ->select([
                    'ec.*',
                    'pv.contrato_id',
                ])
                ->joinSub($subQuery, 'sub', function($join) {
                    $join->on([
                        'sub.created_at' =>  'pv.created_at',
                        'sub.contrato_id' => 'pv.contrato_id'
                    ]);
                })
                ->join('estados_contratos as ec', 'pv.estado_id', 'ec.id');

            $contratos = DB::table('contratos')
                ->select(
                    'trabajadores.*',
                    'contratos.id as contrato_id',
                    'contratos.fecha_inicio',
                    'contratos.group as grupo',
                    'empresas.name as empresa_name',
                    'empresas.id as empresa_id',
                    'zona_labores.name as zona_labor_name',
                    'regimenes.name as regimen',
                    'estados.name as estado',
                    'estados.id as estado_id',
                    'estados.color as estado_color',
                )
                ->join('trabajadores', 'trabajadores.id', '=', 'contratos.trabajador_id')
                ->join('empresas', 'empresas.id', '=', 'contratos.empresa_id')
                ->join('zona_labores', 'zona_labores.id', '=', 'contratos.zona_labor_id')
                ->join('regimenes', 'regimenes.id', '=', 'contratos.regimen_id')
                ->leftJoinSub($subQuery2, 'estados', function($join) {
                    $join->on(['estados.contrato_id' => 'contratos.id']);
                })
                ->whereBetween('contratos.fecha_inicio', [$filtro['desde'], $filtro['hasta']])
                ->where('contratos.empresa_id', $filtro['empresa_id'])
                ->where('trabajadores.nombre', 'LIKE', '%' . ($filtro['nombre'] ?? '') . '%')
                ->where('trabajadores.rut', 'LIKE', '%' . ($filtro['dni'] ?? '') . '%')
                ->where('contratos.observado', false)
                ->whereNull('contratos.deleted_at')
                ->orderBy('trabajadores.apellido_paterno', 'ASC')
                ->orderBy('trabajadores.apellido_materno', 'ASC')
                ->when($filtro['grupo'], function($query) use ($filtro) {
                    $query->where('contratos.group', '=', $filtro['grupo']);
                })
                ->get();

            return $contratos;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function _getObservados($filtro=null)
    {
        try {
            $contratos = DB::table('contratos')
            ->select(
                'trabajadores.*',
                'contratos.id as contrato_id',
                'contratos.fecha_inicio',
                'contratos.group as grupo',
                'empresas.name as empresa_name',
                'empresas.id as empresa_id',
                'zona_labores.name as zona_labor_name'
            )
            ->join('trabajadores', 'trabajadores.id', '=', 'contratos.trabajador_id')
            ->join('empresas', 'empresas.id', '=', 'contratos.empresa_id')
            ->join('zona_labores', 'zona_labores.id', '=', 'contratos.zona_labor_id')
            ->whereBetween('contratos.fecha_inicio', [$filtro['desde'], $filtro['hasta']])
            ->where('contratos.empresa_id', $filtro['empresa_id'])
            ->where('trabajadores.nombre', 'LIKE', '%' . ($filtro['nombre'] ?? '') . '%')
            ->where('trabajadores.rut', 'LIKE', '%' . ($filtro['dni'] ?? '') . '%')
            ->where('contratos.observado', true)
            ->whereNull('contratos.deleted_at')
            ->orderBy('contratos.fecha_inicio', 'DESC')
            ->orderBy('trabajadores.apellido_paterno', 'ASC')
            ->when($filtro['grupo'], function($query) use ($filtro) {
                $query->where('contratos.group', '=', $filtro['grupo']);
            })
            ->get();

            $result = [];
            foreach($contratos as $contrato) {
                $observaciones = DB::table('observaciones')->where([
                    'trabajador_id' => $contrato->id
                ])->get();

                $contrato->observaciones = $observaciones;

                array_push($result, $contrato);
            }

            return $result;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function revision(array $trabajadores=[])
    {
        $registrados = [];
        $no_registrados = [];
        foreach ($trabajadores as $trabajador) {
            $rut = $trabajador['rut'];
            $t =  Trabajador::where('rut', $rut)->first();

            if ($t) {
                $data = [
                    'rut' => $rut,
                    'contrato' => $trabajador
                ];
                array_push($registrados, $data);
            } else {
                array_push($no_registrados, $trabajador);
            }
        }

        return [
            'registrados' => $registrados,
            'no_registrados' => $no_registrados
        ];
    }

    public static function findOrCreate(array $data=[])
    {
        try {
            $trabajador = Trabajador::whereRut($data['rut'])->first();

            $empresa_id = $data['empresa_id'];
            $distrito_id = Distrito::firstWhere('code', $data['distrito_id'])->id;
            $tipo_zona_id = $data['tipo_zona_id'] ? Zona::firstWhere(['code' => $data['tipo_zona_id'],'empresa_id' => $empresa_id])->id : null;
            $tipo_via_id = $data['tipo_via_id'] ? Via::firstWhere(['code' => $data['tipo_via_id'],'empresa_id' => $empresa_id])->id : null;
            $nacionalidad_id = Nacionalidad::firstWhere(['code' => $data['nacionalidad_id'],'empresa_id' => $empresa_id])->id;
            $estado_civil_id = EstadoCivil::firstWhere('code', $data['estado_civil_id'])->id;

            if (!$trabajador) {
                $trabajador = new Trabajador();
            }

            $trabajador->nombre = $data['nombre'];
            $trabajador->code = isset($data['code']) ? $data['code'] : null;
            $trabajador->horario_entrada = isset($data['horario_entrada']) ? $data['horario_entrada'] : null;
            $trabajador->horario_salida = isset($data['horario_salida']) ? $data['horario_salida'] : null;
            $trabajador->rut = $data['rut'];
            $trabajador->apellido_paterno = $data['apellido_paterno'];
            $trabajador->apellido_materno = $data['apellido_materno'];
            $trabajador->fecha_nacimiento = $data['fecha_nacimiento'];
            $trabajador->sexo = $data['sexo'];
            $trabajador->email = $data['email'] ?? null;
            $trabajador->tipo_zona_id = $tipo_zona_id;
            $trabajador->nombre_zona = $data['nombre_zona'];
            $trabajador->tipo_via_id = $tipo_via_id;
            $trabajador->nombre_via = $data['nombre_via'];
            $trabajador->direccion = $data['direccion'];
            $trabajador->distrito_id = $distrito_id;
            $trabajador->estado_civil_id = $estado_civil_id;
            $trabajador->nacionalidad_id = $nacionalidad_id;
            if ( $trabajador->save() ) {
                return $trabajador->id;
            }
            return 0;
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function obtencionReniecMasiva(array $data=[])
    {
        $registrados = $data['registrados'] ?? [];
        $no_registrados = $data['no_registrados'] ?? [];

        $d = array_merge($registrados, $no_registrados);

        foreach ($d as &$a) {
            try {
                $persona = (new ReniecService())->getPersona($a['rut']);
                if (!is_null($persona)) {
                    $a['trabajador'] = $persona;
                    $a['trabajador']['empresa_id'] = $a['contrato']['empresa_id'];
                } else {
                    $a['error'] = 'Persona no encontrada';
                }
            } catch (\Exception $e) {
                $a['error'] = $e->getMessage() . ' -- ' . $e->getLine();
            }
        }

        return $d;
    }

    public static function sctr($data)
    {
        $oficio = DB::table('oficios')
            ->where([
                'empresa_id' => $data['empresa_id'],
                'code' => $data['oficio_id']
            ])
            ->first();

        $cuartel = DB::table('cuarteles as c')
            ->join('zona_labores as zl', 'zl.id', '=', 'c.zona_labor_id')
            ->where([
                'c.empresa_id' => $data['empresa_id'],
                'zl.code' => $data['zona_id'],
                'c.code' => $data['cuartel_id']
            ])
            ->first();

        $oficio_sctr = $oficio ? $oficio->sctr : false;
        $cuartel_sctr = $cuartel ? $cuartel->sctr : false;

        if ($oficio_sctr || $cuartel_sctr) {
            return true;
        } else {
            return false;
        }
    }
}
