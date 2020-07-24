<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contrato extends Model
{
    protected $connection = 'mysql';

    protected $table = 'contratos';

    public function trabajador()
    {
        return $this->belongsTo('App\Models\Trabajador');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Models\Empresa');
    }

    public function zona_labor()
    {
        return $this->belongsTo('App\Models\ZonaLabor');
    }

    public function troncal()
    {
        return $this->belongsTo('App\Models\Troncal');
    }

    public function ruta()
    {
        return $this->belongsTo('App\Models\Ruta');
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

    public function getFechaLargaTerminoAttribute($value)
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        $fecha = Carbon::parse($this->fecha_termino_c);
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

    public function getFechaTerminoFormatAttribute($value)
    {
        return Carbon::parse($this->fecha_termino_c)->format('d/m/Y');
    }

    /**
     * CRUD methods
     */
    public static function _show($id)
    {
        try {
            $contrato = Contrato::findOrFail($id);
            $trabajador = Trabajador::findOrFail($contrato->trabajador_id);
            $distrito = Distrito::findOrFail($trabajador->distrito_id);
            $provincia = Provincia::findOrFail($distrito->provincia_id);
            $departamento = Departamento::findOrFail($provincia->departamento_id);
            $nacionalidad = Nacionalidad::findOrFail($trabajador->nacionalidad_id);
            $estado_civil = EstadoCivil::findOrFail($trabajador->estado_civil_id);
            $tipo_zona = $trabajador->tipo_zona_id ? Zona::findOrFail($trabajador->tipo_zona_id) : false;
            $tipo_via = $trabajador->tipo_via_id ? Via::findOrFail($trabajador->tipo_via_id) : false;

            $zona_labor = ZonaLabor::findOrFail($contrato->zona_labor_id);
            $oficio = Oficio::findOrFail($contrato->oficio_id);
            $cuartel = Cuartel::findOrFail($contrato->cuartel_id);
            $agrupacion = Agrupacion::findOrFail($contrato->agrupacion_id);
            $actividad =  Actividad::findOrFail($contrato->actividad_id);
            $labor = Labor::findOrFail($contrato->labor_id);
            $tipo_contrato = TipoContrato::findOrFail($contrato->tipo_contrato_id);
            $ruta = Ruta::findOrFail($contrato->ruta_id);
            $troncal = Troncal::findOrFail($contrato->troncal_id);

            return [
                'contrato' => [
                    'id' => $contrato->id,
                    'fecha_inicio' => $contrato->fecha_inicio,
                    'fecha_ingreso' => $contrato->fecha_inicio,
                    'fecha_termino' => $contrato->fecha_termino_c,
                    'empresa_id' => $contrato->empresa_id,
                    'zona_labor_id' => $zona_labor->code,
                    'grupo' => $contrato->group,
                    'regimen_id' => $contrato->regimen_id,
                    'oficio_id' => $oficio->code,
                    'cuartel_id' => $cuartel->code,
                    'agrupacion_id' => $agrupacion->code,
                    'actividad_id' => $actividad->code,
                    'labor_id' => $labor->code,
                    'tipo_contrato_id' => $tipo_contrato->code,
                    'ruta_id' => $ruta->code,
                    'troncal_id' => $troncal->code,
                    'codigo_bus' => $contrato->codigo_bus,
                    'tipo_trabajador' => $contrato->tipo_trabajador,
                ],
                'trabajador' => [
                    'rut' => $trabajador->rut,
                    'apellido_paterno' => $trabajador->apellido_paterno,
                    'apellido_materno' => $trabajador->apellido_materno,
                    'nombre' => $trabajador->nombre,
                    'fecha_nacimiento' => $trabajador->fecha_nacimiento,
                    'sexo' => $trabajador->sexo,
                    'telefono' => $trabajador->telefono,
                    'distrito_id' => $distrito->code,
                    'provincia_id' => $provincia->code,
                    'departamento_id' => $departamento->code,
                    'nacionalidad_id' => $nacionalidad->code,
                    'estado_civil_id' => $estado_civil->code,
                    'tipo_zona_id' => $trabajador->tipo_zona_id ? $tipo_zona->code : "",
                    'nombre_zona' => $trabajador->nombre_zona,
                    'tipo_via_id' => $trabajador->tipo_via_id ? $tipo_via->code : "",
                    'nombre_via' => $trabajador->nombre_via,
                    'direccion' => $trabajador->direccion
                ]
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function getZonaLaborContrato(Contrato $contrato)
    {
        if ($contrato->regimen_id !== 3) {
            return $contrato->zona_labor;
        }

        $name = trim(explode('(', $contrato->zona_labor->name)[0]);
        $zona_labor = ZonaLabor::where('name', 'like', '%'. $name .'%')->where('name', 'like', '%OBREROS%')->first();
        if ($zona_labor) {
            return $zona_labor;
        } else {
            return $contrato->zona_labor;
        }
    }

    public static function _showFila($id)
    {
        try {
            $contrato = Contrato::findOrFail($id);
            $trabajador = Trabajador::findOrFail($contrato->trabajador_id);

            $estado_civil = EstadoCivil::findOrFail($trabajador->estado_civil_id);
            $distrito = Distrito::findOrFail($trabajador->distrito_id);
            $nacionalidad = Nacionalidad::findOrFail($trabajador->nacionalidad_id);
            $tipo_zona = $trabajador->tipo_zona_id ? Zona::findOrFail($trabajador->tipo_zona_id) : false;
            $tipo_via = $trabajador->tipo_via_id ? Via::findOrFail($trabajador->tipo_via_id) : false;

            $zona_labor = ZonaLabor::findOrFail($contrato->zona_labor_id);
            $zona_labor_contrato = Contrato::getZonaLaborContrato($contrato);
            $oficio = Oficio::findOrFail($contrato->oficio_id);
            $cuartel = Cuartel::findOrFail($contrato->cuartel_id);
            $agrupacion = Agrupacion::findOrFail($contrato->agrupacion_id);
            $actividad =  Actividad::findOrFail($contrato->actividad_id);
            $labor = Labor::findOrFail($contrato->labor_id);
            $tipo_contrato = TipoContrato::findOrFail($contrato->tipo_contrato_id);
            $ruta = Ruta::findOrFail($contrato->ruta_id);
            $troncal = Troncal::findOrFail($contrato->troncal_id);

            return [
                'DNI' => $trabajador->rut,
                'TIPODOCIDEN' => '1',
                'APELLIDOP' => $trabajador->apellido_paterno,
                'APELLIDOM' => $trabajador->apellido_materno,
                'NOMBRES' => $trabajador->nombre,
                'FECHA NAC' => Carbon::parse($trabajador->fecha_nacimiento)->format('d/m/Y'),
                'ESTADO' => $estado_civil->code,
                'SEXO' => $trabajador->sexo,
                'NACIONALIDAD' => $nacionalidad->code,
                'DIRECCION' => $trabajador->direccion,
                'COMUNA' => $distrito->code,
                'ZONA LABORES' => $zona_labor->code,
                'TIPO DE ZONA' => $trabajador->tipo_zona_id ? $tipo_zona->code : "",
                'NOMBRE ZONA' => $trabajador->nombre_zona,
                'TIPO DE VIA' => $trabajador->tipo_via_id ? $tipo_via->code : "",
                'NOMBRE VIA' => $trabajador->nombre_via,
                'MANZANA' => '',
                'LOTE' => '',
                'NUMERO' => '',
                'INTERIOR' => '',
                'NIVEL EDUCACIONAL' => 4,
                'TRONCAL' => $troncal->code,
                'RUTA' => $ruta->code,
                'TELEFONO' => '',
                'TIPO DE TRABAJADOR' => 64,
                'T. TRABAJADOR' => 2,
                'A.F.P.' => 'VALIDAR',
                'ISAPRE' => 1,
                'MONEDA' => 4,
                'Comisión' => '',
                'CUSSP' => 'VALIDAR',
                'MIXTA' => 'VALIDAR',
                'F. AFILIACION' => Carbon::parse($contrato->fecha_inicio)->format('d/m/Y'),
                'REGIMEN' => $contrato->regimen_id,
                'C. COSTO/ PREDIO' => $zona_labor_contrato->code,
                'SC.COSTO/CUARTEL' => $cuartel->code,
                'AGRUPACION' => $agrupacion->code,
                'ACTIVIDAD' => $actividad->code,
                'LABOR' => $labor->code,
                'OFICIO' => $oficio->code,
                'SUELDO DIARIO' => 31.01,
                'MONEDASUELDO' => 4,
                'Fecha de Inicio' => Carbon::parse($contrato->fecha_inicio)->format('d/m/Y'),
                'Fecha de Término' => Carbon::parse($contrato->fecha_termino_c)->format('d/m/Y'),
                'TIPO DE CONTRATO' => $tipo_contrato->code,
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function _showFichaTrabajador($id)
    {
        try {
            $contrato = Contrato::findOrFail($id);
            $trabajador = Trabajador::findOrFail($contrato->trabajador_id);

            return [
                '' => '',
                'RutTrabajador' => $trabajador->rut,
                'CodigoTrabajador' => '',
                'Ap.Paterno' => $trabajador->apellido_paterno,
                'Ap. Materno' => $trabajador->apellido_materno,
                'Nombre' => $trabajador->nombre,
                'FechaNacimiento' => Carbon::parse($trabajador->fecha_nacimiento)->format('d/m/Y'),
                'F. Nac. Letras' => Carbon::parse($trabajador->fecha_nacimiento)->format('d/m/Y'),
                'Edad' => $trabajador->age,
                'Sexo' => $trabajador->sexo,
                'Direccion' => $trabajador->direccion,
                'DISTRITO' => $trabajador->distrito->name,
                'PROVINCIA' => $trabajador->distrito->provincia->name,
                'DEPARTAMENTO' => $trabajador->distrito->provincia->departamento->name,
                'EstadoCivil' => $trabajador->estado_civil->code,
                'F. Ingreso' => Carbon::parse($contrato->fecha_inicio)->format('d/m/Y'),
                'F. Ingreso Letras' => $contrato->fecha_larga,
                'F. Término Letras' => $contrato->fecha_larga_termino,
                'Activo' => '',
                'Alerta' => '',
                'GRUPO' => $contrato->group,
                'CODIGO' => $contrato->codigo_bus,
                'TRONCAL' => $contrato->troncal->name,
                'RUTA' => $contrato->ruta->name,
                'Mes de Desc. Antec. Polic.' => '',
                'Mes Desc. Letras' => '',
                'FUNDO' => $contrato->zona_labor->name,
                'ESTADO CIVIL' => $trabajador->estado_civil->name,
                'TELEFONO' => '',
                'EMAIL' => '',
                'EMPRESA' => $contrato->empresa_id == 9 ? 'RAPEL' : 'VERFRUT',
            ];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public static function massiveRecord(array $data=[])
    {
        $registrados = $data['registrados'];
        $guardados = [];
        $errores = [];

        foreach($registrados as $registrado) {
            if ( isset($registrado['error']) ) {
                array_push($errores, [
                    'rut' => $registrado['rut'],
                    'error' => $registrado['error']
                ]);
            } else {
                try {
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
                } catch (\Exception $e) {
                    array_push($errores, [
                        'error' => $e->getMessage()
                    ]);
                }
            }
        }

        return [
            'guardados' => $guardados,
            'errores' => $errores
        ];
    }

    public static function record(array $data=[])
    {
        DB::beginTransaction();
        try {
            $contrato_data = $data['contrato'];

            $trabajador_id = Trabajador::findOrCreate($data['trabajador']);
            $zona_labor_id = ZonaLabor::findOrCreate($contrato_data['zona_labor']);
            $oficio_id = Oficio::findOrCreate($contrato_data['oficio']);
            $regimen_id = Regimen::findOrCreate($contrato_data['regimen']);
            $actividad_id = Actividad::findOrCreate($contrato_data['actividad']);
            $agrupacion_id = Agrupacion::findOrCreate($contrato_data['agrupacion']);
            $cuartel_id = Cuartel::findOrCreate($contrato_data['cuartel'], $zona_labor_id);
            $tipo_contrato_id = TipoContrato::findOrCreate($contrato_data['tipo_contrato']);
            $labor_id = Labor::findOrCreate($contrato_data['labor'], $actividad_id);
            $troncal_id = Troncal::findOrCreate($contrato_data['troncal']);
            $ruta_id = Ruta::findOrCreate($contrato_data['ruta'], $troncal_id);

            $contrato_activo = $data['contrato_activo'] ?? [];
            $alertas = $data['alertas'] ?? [];

            $existe_contrato = Contrato::where([
                'trabajador_id' => $trabajador_id,
                'fecha_inicio'  =>  $contrato_data['fecha_ingreso'],
            ])->exists();

            if (!isset($contrato_data['id'])) {
                if ($existe_contrato) {
                    DB::rollBack();
                    return [
                        'rut' => $data['rut'],
                        'error' => 'Ya existe un contrato generado con fecha de ingreso ' . $contrato_data['fecha_ingreso']
                    ];
                }
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
            if (isset($contrato_data['id'])) {
                $contrato = Contrato::find($contrato_data['id']);
            } else {
                $contrato = new Contrato();
            }
            $contrato->editable = true;
            $contrato->cargado = false;
            $contrato->activo = true;
            $contrato->observado = $observado;
            $contrato->fecha_inicio = $contrato_data['fecha_ingreso'];
            $contrato->fecha_termino_c = $contrato_data['fecha_termino'];
            $contrato->empresa_id = $contrato_data['empresa_id'];
            $contrato->group = $contrato_data['grupo'];
            $contrato->codigo_bus = $contrato_data['codigo_bus'] ?? null;
            $contrato->tipo_trabajador = $contrato_data['tipo_trabajador'];
            $contrato->zona_labor_id = $zona_labor_id;
            $contrato->trabajador_id = $trabajador_id;
            $contrato->oficio_id = $oficio_id;
            $contrato->regimen_id = $regimen_id;
            $contrato->actividad_id = $actividad_id;
            $contrato->agrupacion_id = $agrupacion_id;
            $contrato->tipo_contrato_id = $tipo_contrato_id;
            $contrato->cuartel_id = $cuartel_id;
            $contrato->labor_id = $labor_id;
            $contrato->troncal_id = $troncal_id;
            $contrato->ruta_id = $ruta_id;
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

    /**
     * TODO: Impementacion de la funcion
     * @param array $contratos
     * @param $datos_contrato
     * @return array
     */
    public static function massiveEdit(array $contratos, $datos_contrato)
    {
        return $contratos;
    }
}
