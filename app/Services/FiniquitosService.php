<?php


namespace App\Services;

use App\Models\Finiquito;
use App\Models\Oficio;
use App\Models\SqlSrv\Trabajador;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class FiniquitosService
{
    public PersonasService $personasService;

    public function __construct()
    {
        $this->personasService = new PersonasService();
    }

    public function prepare($request)
    {
        $personaId = $this->personasService->create(
            $request->persona['id'],
            $request->persona['nombre'],
            $request->persona['apellido_paterno'],
            $request->persona['apellido_materno'],
            $request->persona['fecha_nacimiento'],
            $request->persona['sexo'],
            $request->persona['direccion']
        );

        $oficioId = Oficio::findOrCreate([
            'id' => $request->oficio['id'],
            'empresa_id' => $request->empresa_id,
            'name' => $request->oficio['name']
        ]);

        return [
            'personaId' => $personaId,
            'oficioId' => $oficioId
        ];
    }

    public function create(
        $empresaId, $personaId, $tipoCeseId, $grupoFiniquitoId = null,
        $fechaInicioPeriodo, $fechaTerminaoContrato, $regimenId, $oficioId, $usuarioId,
        $fechaFiniquito = null, $zonaLabor = null, $id = null
    )
    {
        if ($grupoFiniquitoId) {
            $exists = Finiquito::where([
                'persona_id' => $personaId,
                'grupo_finiquito_id' => $grupoFiniquitoId
            ])->exists();

            if ($exists) {
                return [
                    'message' => 'Ya existe ese trabajador en este grupo',
                    'error' => true,
                    'data' => []
                ];
            }
        } else {
            $exists = Finiquito::where([
                'persona_id' => $personaId,
                'fecha_finiquito' => $fechaFiniquito
            ])->first();

            if ($exists) {
                if (!$id) {
                    return [
                        'message' => 'Ya existe un registro de este trabajador para la fecha ' . $fechaFiniquito,
                        'data' => [],
                        'error' => true
                    ];
                }
            }
        }

        try {
            if ($id) {
                $finiquito = Finiquito::find($id);
            } else {
                $finiquito = new Finiquito();
            }

            $finiquito->empresa_id = $empresaId;
            $finiquito->persona_id = $personaId;
            $finiquito->oficio_id = $oficioId;
            $finiquito->tipo_cese_id = $grupoFiniquitoId ? $tipoCeseId : 2;
            $finiquito->regimen_id = $regimenId;
            $finiquito->grupo_finiquito_id = $grupoFiniquitoId;
            $finiquito->fecha_inicio_periodo = $fechaInicioPeriodo;
            $finiquito->fecha_termino_contrato = $fechaTerminaoContrato;
            $finiquito->usuario_id = $usuarioId;
            $finiquito->fecha_finiquito = $fechaFiniquito;
            $finiquito->zona_labor = $zonaLabor;
            $finiquito->save();

            return [
                'message' => 'Finiquito creado correctamente',
                'data' => $finiquito,
            ];
        } catch (\Exception $e) {
            return [
                'message' => 'Error al crear finiquito',
                'error' => true,
                'data' => $e->getMessage() . ' -- ' . $e->getLine()
            ];
        }
    }

    public function changeState($estadoId, $id)
    {
        $finiquito = Finiquito::find($id);

        if ($finiquito->setEstado($estadoId)) {

            return [
                'message' => 'Estado cambiando correctamente',
                'data' => $finiquito
            ];
        } else {
            return [
                'message' => 'Algo salió mal',
                'error' => true,
                'data' => $finiquito
            ];
        }
    }

    public function delete($id)
    {
        $finiquito = Finiquito::find($id);

        if ($finiquito->getEstado()->name === 'SIN EFECTO') {
            $finiquito->delete();
        } else {
            $this->changeState(3, $finiquito->id);
        }

        return [
            'message' => 'Finiquito borrado correctamente',
            'data' => $id
        ];
    }

    public function print(Finiquito $finiquito)
    {
        try {
            $data = [
                'finiquito'     => $finiquito,
                'trabajador'     => $finiquito->trabajador,
                'codigo'         => 6 . '@' . $finiquito->id,
            ];

            $pdf = \PDF::setOptions([
                'images' => true
            ])->loadView('documents.' . $finiquito->tipoCese->sigla . '.index', $data)->output();

            $filename = '/cargas-finiquitos/' . $finiquito->grupo_finiquito_id . '/' . $finiquito->persona->apellido_paterno . '-' .
                $finiquito->persona->apellido_materno . '-' .
                $finiquito->persona->id . '-' .
                $finiquito->empresa->shortname . '-' .
                $finiquito->tipoCese->sigla . '.pdf';

            if (Storage::disk('public')->put($filename, $pdf)) {
                return [
                    'filename' => $filename,
                    'error' => false
                ];
            } else {
                return [
                    'error' => 'No se guardo el archivo',
                ];
            }

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage() . ' -- ' . $e->getLine()
            ]);
        }
    }

    public function import($fileName, $fechaFiniquito, $grupoFiniquitoId, $usuarioId)
    {
        $trabajadores = [];
        $errores = [];
        try {
            $id = DB::table('importaciones_finquitos')->insertGetId([
                'name' => 'IMPORTACION ' . now()->toDateTimeString(),
                'fecha_hora' => now()->toDateTimeString(),
                'grupo_finiquito_id' => $grupoFiniquitoId
            ]);


            (new FastExcel)
                ->import(storage_path('app/public') . $fileName, function($line) use (&$trabajadores, &$errores, $fechaFiniquito, $id) {

                    $trabajador = Trabajador::getTrabajadorParaFiniquito($line['RUT'], $fechaFiniquito, true);
                    if (!isset($trabajador['error'])) {
                        array_push($trabajadores, (object) $trabajador['data']);
                    } else {
                        array_push($errores, $trabajador);

                        DB::table('observaciones_importaciones_finiquitos')->insert([
                            'rut' => $trabajador['data']['rut'],
                            'descripcion' => $trabajador['message'],
                            'importacion_finiquito_id' => $id
                        ]);
                    }
                });

            $results = [];
            $warnings = [];

            foreach ($trabajadores as $trabajador) {
                try {
                    ["personaId" => $personaId, "oficioId" => $oficioId] = $this->prepare($trabajador);

                    $finiquito = $this->create(
                        $trabajador->empresa_id,
                        $personaId,
                        $trabajador->tipo_cese_id,
                        $grupoFiniquitoId,
                        $trabajador->fecha_inicio_periodo,
                        $trabajador->fecha_termino_contrato,
                        $trabajador->regimen_id,
                        $oficioId,
                        $usuarioId,
                    );

                    if ($trabajador->regimen_id == 3) {
                        array_push($results, [
                            'message' => 'Trabajador agregado correctamente',
                            'data' => [
                                'rut' => $trabajador->persona_id
                            ]
                        ]);
                    } else {
                        array_push($warnings, [
                            'message' => 'Se ha agregado un EMPLEADO AGRARIO. Por favor revisar',
                            'data' => [
                                'rut' => $trabajador->persona_id
                            ]
                        ]);
                    }

                } catch (\Exception $e) {
                    array_push($errores, [
                        'message' => $e->getMessage(),
                        'data' => [
                            'rut' => $trabajador->persona_id
                        ]
                    ]);
                }
            }

            return [
                'message'   => 'Importación completada existosamente',
                'data'      => [
                    'errores'   => $errores,
                    'advertencias' => $warnings,
                    'correctos'    => $results,
                    'importacion_finiquito_id' => $id,
                ]
            ];
        } catch (\Exception $e) {
            return [
                'message'   => $e->getMessage() !== 'Undefined index: RUT' ? "Error al importar" : (
                    'El archivo debe tener la columna "RUT"'
                ),
                'data'      => [
                    'error' => $e->getMessage() . ' --- ' . $e->getLine()
                ],
                'error'     => true
            ];
        }
    }
}
