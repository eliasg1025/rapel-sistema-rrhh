<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Distrito;
use App\Models\Empresa;
use App\Models\Nacionalidad;
use App\Models\Provincia;
use App\Models\Via;
use App\Models\Zona;
use App\Models\ZonaLabor;
use Illuminate\Http\Request;

class ActualizarController extends Controller
{
    public function porEmpresa(Request $request)
    {
        $nacionalidades = $request->nacionalidades;
        $tipos_zonas = $request->tipos_zonas;
        $tipos_vias = $request->tipos_vias;
        $zonas_labor = $request->zonas_labor;

        try {
            for ($i = 0; $i < sizeof($nacionalidades); $i++) {

                $empresa = $nacionalidades[$i]['empresa_id'] === '9' ? 1 : 2;
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

                $empresa = $tipos_vias[$i]['empresa_id'] === '9' ? 1 : 2;
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

                $empresa = $tipos_zonas[$i]['empresa_id'] === '9' ? 1 : 2;
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

                $empresa = $zonas_labor[$i]['empresa_id'] === '9' ? 1 : 2;
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
