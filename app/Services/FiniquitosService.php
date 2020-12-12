<?php


namespace App\Services;

use App\Models\Finiquito;
use App\Models\Oficio;
use App\Models\SqlSrv\Trabajador;
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
            'id' => $request->oficio_id,
            'empresa_id' => $request->empresa_id,
            'name' => $request->oficio_name
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
            $finiquito->tipo_cese_id = $tipoCeseId;
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

    public function import($fileName, $fechaFiniquito, $grupoFiniquitoId)
    {
        $trabajadores = [];
        $errores = [];
        try {
            (new FastExcel)
                ->import(storage_path('app/public') . $fileName, function($line) use (&$trabajadores, &$errores, $fechaFiniquito) {

                    $trabajador = Trabajador::getTrabajadorParaFiniquito($line['RUT'], $fechaFiniquito);
                    if (!isset($trabajador['error'])) {
                        array_push($trabajadores, (object) $trabajador['data']);
                    } else {
                        array_push($errores, $trabajador);;
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
                        $grupoFiniquitoId->usuario_id,
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
                    'correctos'    => $results
                ]
            ];
        } catch (\Exception $e) {
            return [
                'message'   => 'Error al importar',
                'data'      => $e->getMessage(),
                'error'     => true
            ];
        }
    }
}
