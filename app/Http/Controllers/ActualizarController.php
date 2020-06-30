<?php

namespace App\Http\Controllers;

use App\Models\Cuartel;
use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Empresa;
use App\Models\Nacionalidad;
use App\Models\Provincia;
use App\Models\Via;
use App\Models\Zona;
use App\Models\ZonaLabor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActualizarController extends Controller
{
    public function porEmpresa(Request $request)
    {
        $nacionalidades = $request->nacionalidades;
        $tipos_zonas = $request->tipos_zonas;
        $tipos_vias = $request->tipos_vias;
        $zonas_labor = $request->zonas_labor;
        /*
        $oficios = $request->oficios;
        $regimenes = $request->regimenes;
        $actividades = $request->actividades;
        $cuarteles = $request->cuarteles;
        $agrupaciones = $request->agrupaciones;
        $labores = $request->labores;
        $tipos_contratos = $request->tipos_contratos;*/

        try {
            for ($i = 0; $i < sizeof($nacionalidades); $i++) {

                $empresa = $nacionalidades[$i]['empresa_id'];
                $doesntExist = Nacionalidad::where([
                    'code' => $nacionalidades[$i]['id'],
                    'empresa_id' => $empresa
                ])->doesntExist();

                if ($doesntExist) {
                    $nacionalidad = new Nacionalidad();
                    $nacionalidad->code = $nacionalidades[$i]['id'];
                    $nacionalidad->name = $nacionalidades[$i]['name'];
                    $nacionalidad->empresa_id = $empresa;
                    $nacionalidad->save();
                } else {
                    $nacionalidad = Nacionalidad::firstWhere([
                        'code' => $nacionalidades[$i]['id'],
                        'empresa_id' => $empresa,
                    ]);
                    $nacionalidad->name = $nacionalidades[$i]['name'];
                    $nacionalidad->empresa_id = $empresa;
                    $nacionalidad->save();
                }
            }

            for ($i = 0; $i < sizeof($tipos_vias); $i++) {

                $empresa = $tipos_vias[$i]['empresa_id'];
                $doesntExist = Via::where([
                    'code' => $tipos_vias[$i]['id'],
                    'empresa_id' => $empresa
                ])->doesntExist();

                if ($doesntExist) {
                    $tipo_via = new Via();
                    $tipo_via->code = $tipos_vias[$i]['id'];
                    $tipo_via->name = $tipos_vias[$i]['name'];
                    $tipo_via->empresa_id = $empresa;
                    $tipo_via->save();
                } else {
                    $tipo_via = Via::firstWhere([
                        'code' => $tipos_vias[$i]['id'],
                        'empresa_id' => $empresa,
                    ]);
                    $tipo_via->name = $tipos_vias[$i]['name'];
                    $tipo_via->save();
                }
            }

            for ($i = 0; $i < sizeof($tipos_zonas); $i++) {

                $empresa = $tipos_zonas[$i]['empresa_id'];
                $doesntExist = Zona::where([
                    'code' => $tipos_zonas[$i]['id'],
                    'empresa_id' => $empresa
                ])->doesntExist();

                if ($doesntExist) {
                    $tipo_zona = new Zona();
                    $tipo_zona->code = $tipos_zonas[$i]['id'];
                    $tipo_zona->name = $tipos_zonas[$i]['name'];
                    $tipo_zona->empresa_id = $empresa;
                    $tipo_zona->save();
                } else {
                    $tipo_zona = Zona::firstWhere([
                        'code' => $tipos_zonas[$i]['id'],
                        'empresa_id' => $empresa,
                    ]);
                    $tipo_zona->name = $tipos_zonas[$i]['name'];
                    $tipo_zona->save();
                }
            }

            for ($i = 0; $i < sizeof($zonas_labor); $i++) {

                $empresa = $zonas_labor[$i]['empresa_id'];
                $doesntExist = ZonaLabor::where([
                    'code' => $zonas_labor[$i]['id'],
                    'empresa_id' => $empresa
                ])->doesntExist();

                if ($doesntExist) {
                    $zona_labor = new ZonaLabor();
                    $zona_labor->code = $zonas_labor[$i]['id'];
                    $zona_labor->name = $zonas_labor[$i]['name'];
                    $zona_labor->empresa_id = $empresa;
                    $zona_labor->save();
                } else {
                    $zona_labor = ZonaLabor::firstWhere([
                        'code' => $zonas_labor[$i]['id'],
                        'empresa_id' => $empresa,
                    ]);
                    $zona_labor->name = $zonas_labor[$i]['name'];
                    $zona_labor->save();
                }
            }

            /*
            for ($i = 0; $i < sizeof($oficios); $i++) {
                $doesntExist = DB::table('oficios')->where([
                    'code' => $oficios[$i]['id'],
                    'empresa_id' => $oficios[$i]['empresa_id']
                ])->doesntExist();

                if ($doesntExist) {
                    DB::table('oficios')->insert([
                        'code' => $oficios[$i]['id'],
                        'name' => $oficios[$i]['name'],
                        'cod_equ' => $oficios[$i]['cod_equ'],
                        'empresa_id' => $oficios[$i]['empresa_id']
                    ]);
                } else {
                    $oficio = DB::table('oficios')->where([
                        'code' => $oficios[$i]['id'],
                        'empresa_id' => $oficios[$i]['empresa_id']
                    ])->first();
                    $oficio->name = $oficios[$i]['name'];
                    $oficio->cod_equ = $oficios[$i]['cod_equ'];
                    $oficio->save();
                }
            }

            for ($i = 0; $i < sizeof($regimenes); $i++) {
                $doesntExist = DB::table('regimenes')->where([
                    'id' => (int) $regimenes[$i]['id'],
                ])->doesntExist();

                if ($doesntExist) {
                    DB::table('regimenes')->insert([
                        'id' => (int) $regimenes[$i]['id'],
                        'name' => $regimenes[$i]['name'],
                    ]);
                } else {
                    $oficio = DB::table('regimenes')->where([
                        'id' => (int) $regimenes[$i]['id'],
                    ])->first();
                    $oficio->name = $regimenes[$i]['name'];
                    $oficio->save();
                }
            }

            for ($i = 0; $i < sizeof($actividades); $i++) {
                $doesntExist = DB::table('actividades')->where([
                    'code' => $actividades[$i]['id'],
                    'empresa_id' => $actividades[$i]['empresa_id']
                ])->doesntExist();

                if ($doesntExist) {
                    DB::table('actividades')->insert([
                        'code' => $actividades[$i]['id'],
                        'name' => $actividades[$i]['name'],
                        'cod_cuenta' => $actividades[$i]['cod_cuenta'],
                        'empresa_id' => $actividades[$i]['empresa_id']
                    ]);
                } else {
                    $actividad = DB::table('actividades')->where([
                        'code' => $actividades[$i]['id'],
                        'empresa_id' => $actividades[$i]['empresa_id']
                    ])->first();
                    $actividad->name = $actividades[$i]['name'];
                    $actividad->cod_cuenta = $actividades[$i]['cod_cuenta'];
                    $actividad->save();
                }
            }

            for ($i = 0; $i < sizeof($agrupaciones); $i++) {
                $doesntExist = DB::table('agrupaciones')->where([
                    'code' => $agrupaciones[$i]['id'],
                    'empresa_id' => $agrupaciones[$i]['empresa_id']
                ])->doesntExist();

                if ($doesntExist) {
                    DB::table('agrupaciones')->insert([
                        'code' => $agrupaciones[$i]['id'],
                        'name' => $agrupaciones[$i]['name'],
                        'empresa_id' => $agrupaciones[$i]['empresa_id']
                    ]);
                } else {
                    $agrupacion = DB::table('agrupaciones')->where([
                        'code' => $agrupaciones[$i]['id'],
                        'empresa_id' => $agrupaciones[$i]['empresa_id']
                    ])->first();
                    $agrupacion->name = $agrupaciones[$i]['name'];
                    $agrupacion->save();
                }
            }

            for ($i = 0; $i < sizeof($cuarteles); $i++) {
                $zona_labor = DB::table('zona_labores')->where([
                    'empresa_id' => $cuarteles[$i]['empresa_id'],
                    'code' => $cuarteles[$i]['zona_labor_id']
                ])->first();

                $doesntExist = DB::table('cuarteles')->where([
                    'code' => $cuarteles[$i]['id'],
                    'empresa_id' => $cuarteles[$i]['empresa_id'],
                    'zona_labor_id' => $zona_labor->id
                ])->doesntExist();

                if ($doesntExist) {
                    DB::table('cuarteles')->insert([
                        'code' => $cuarteles[$i]['id'],
                        'name' => $cuarteles[$i]['name'],
                        'cod_subcentro' => $cuarteles[$i]['cod_subcentro'],
                        'nom_subcentro' => $cuarteles[$i]['nom_subcentro'],
                        'zona_labor_id' => $zona_labor->id,
                        'empresa_id' => $cuarteles[$i]['empresa_id']
                    ]);
                } else {
                    $cuartel = DB::table('cuarteles')->where([
                        'code' => $cuarteles[$i]['id'],
                        'empresa_id' => $cuarteles[$i]['empresa_id'],
                        'zona_labor_id' => $zona_labor->id
                    ])->first();
                    $cuartel->name = $cuarteles[$i]['name'];
                    $cuartel->cod_subcentro = $cuarteles[$i]['cod_subcentro'];
                    $cuartel->nom_subcentro = $cuarteles[$i]['nom_subcentro'];
                    $cuartel->save();
                }
            }

            for ($i = 0; $i < sizeof($labores); $i++) {
                $actividad = DB::table('actividades')->where([
                    'empresa_id' => $labores[$i]['empresa_id'],
                    'code' => $labores[$i]['actividad_id']
                ])->first();

                $doesntExist = DB::table('labores')->where([
                    'code' => $labores[$i]['id'],
                    'empresa_id' => $labores[$i]['empresa_id'],
                    'actividad_id' => $actividad->id
                ])->doesntExist();

                if ($doesntExist) {
                    DB::table('labores')->insert([
                        'code' => $labores[$i]['id'],
                        'name' => $labores[$i]['name'],
                        'unidad_medida' => $labores[$i]['unidad_medida'],
                        'actividad_id' => $actividad->id,
                        'empresa_id' => $labores[$i]['empresa_id']
                    ]);
                } else {
                    $cuartel = DB::table('labores')->where([
                        'code' => $labores[$i]['id'],
                        'empresa_id' => $labores[$i]['empresa_id'],
                        'actividad_id' => $actividad->id
                    ])->first();
                    $cuartel->name = $labores[$i]['name'];
                    $cuartel->unidad_medida = $labores[$i]['unidad_medida'];
                    $cuartel->save();
                }
            }

            for ($i = 0; $i < sizeof($tipos_contratos); $i++) {
                $doesntExist = DB::table('tipo_contratos')->where([
                    'code' => $tipos_contratos[$i]['id'],
                    'empresa_id' => $tipos_contratos[$i]['empresa_id']
                ])->doesntExist();

                if ($doesntExist) {
                    DB::table('tipo_contratos')->insert([
                        'code'       => $tipos_contratos[$i]['id'],
                        'name'       => $tipos_contratos[$i]['name'],
                        'empresa_id' => $tipos_contratos[$i]['empresa_id'],
                        'cod_equ'    => $tipos_contratos[$i]['cod_equ']
                    ]);
                } else {
                    $tipos_contrato = DB::table('tipo_contratos')->where([
                        'code'       => $tipos_contratos[$i]['id'],
                        'empresa_id' => $tipos_contratos[$i]['empresa_id']
                    ])->first();
                    $tipos_contrato->name = $tipos_contratos[$i]['name'];
                    $tipos_contrato->cod_equ = $tipos_contratos[$i]['cod_equ'];
                    $tipos_contrato->save();
                }
            }*/

            return response()->json([
                'message' => 'Actualizacion completada exitosamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function localidades(Request $request)
    {
        $departamentos = $request->departamentos;
        $provincias = $request->provincias;
        $distritos = $request->distritos;

        try {
            for ($i = 0; $i < sizeof($departamentos); $i++) {

                $doesntExist = Departamento::where([
                    'code' => $departamentos[$i]['id'],
                ])->doesntExist();

                if ($doesntExist) {
                    $departamento = new Departamento();
                    $departamento->code = $departamentos[$i]['id'];
                    $departamento->name = $departamentos[$i]['name'];
                    $departamento->save();
                } else {
                    $departamento = Departamento::firstWhere([
                        'code' => $departamentos[$i]['id']
                    ]);
                    $departamento->name = $departamentos[$i]['name'];
                    $departamento->save();
                }
            }

            for ($i = 0; $i < sizeof($provincias); $i++) {

                $doesntExist = Provincia::where([
                    'code' => $provincias[$i]['id'],
                ])->doesntExist();

                if ($doesntExist) {
                    $provincia = new Provincia();
                    $provincia->code = $provincias[$i]['id'];
                    $provincia->name = $provincias[$i]['name'];
                    $provincia->departamento_id = Departamento::firstWhere('code', $provincias[$i]['departamento_id'])->id;
                    $provincia->save();
                } else {
                    $provincia = Provincia::firstWhere([
                        'code' => $provincias[$i]['id']
                    ]);
                    $provincia->name = $provincias[$i]['name'];
                    $provincia->departamento_id = Departamento::firstWhere('code', $provincias[$i]['departamento_id'])->id;
                    $provincia->save();
                }
            }

            for ($i = 0; $i < sizeof($distritos); $i++) {

                $doesntExist = Distrito::where([
                    'code' => $distritos[$i]['id'],
                ])->doesntExist();

                if ($doesntExist) {
                    $distrito = new Distrito();
                    $distrito->code = $distritos[$i]['id'];
                    $distrito->name = $distritos[$i]['name'];
                    $distrito->provincia_id = Provincia::firstWhere('code', $distritos[$i]['provincia_id'])->id;
                    $distrito->save();
                } else {
                    $distrito = Distrito::firstWhere([
                        'code' => $distritos[$i]['id']
                    ]);
                    $distrito->name = $distritos[$i]['name'];
                    $distrito->provincia_id = Provincia::firstWhere('code', $distritos[$i]['provincia_id'])->id;
                    $distrito->save();
                }
            }

            return response()->json([
                'message' => 'Datos de las localidades actualizados correctamente'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
