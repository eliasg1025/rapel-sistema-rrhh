<?php


namespace App\Services;


use App\Models\Departamento;
use App\Models\EstadoCivil;
use App\Models\Provincia;
use App\Traits\ConsumeApi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReniecService
{
    use ConsumeApi;

    public $base_url;

    public function __construct()
    {
        $this->base_url = env('RENIEC_API');
    }

    public function getPersona($dni)
    {
        try {
            // $path = $dni . '/' . $imagenes;
            $path = env('RENIEC_API') . "?dni=$dni&refresh=true";
            $response = $this->sendRequest('POST', $path, ['dni' => $dni]);

            $content = json_decode($response['content']);
            if ($content->success) {
                $result = $content->result;
                return $this->formatData($result);
            }

            throw new \Exception('Persona no encontrada');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private function formatData($data)
    {
        try {
            $estado = $data->estado_civil === "" || $data->estado_civil === 'null'
                ? "SOLTERO"
                : explode('(', $data->estado_civil)[0];

            $estado_civil_code = DB::table('estado_civiles')->where('name', 'like', $estado)->first()->code;

            if ($data->ubi_dir_depa_desc == "")
            {
                $provincia_id = 67; // CALLAO
            }
            else
            {
                if ($data->ubi_dir_depa_desc == "CUSCO") // CUZCO
                {
                    $departamento_id = 8;
                }
                elseif ($data->ubi_dir_depa_desc == "AMAZONAS") // AMAMZONAS
                {
                    $departamento_id = 1;
                }
                else
                {
                    $departamento_id = DB::table('departamentos')->where('name', $data->ubi_dir_depa_desc)->first()->id;
                }

                $provincia_id = DB::table('provincias')->where([
                    'name'              => $data->ubi_dir_prov_desc,
                    'departamento_id'   => $departamento_id
                ])->first()->id;
            }

            $distrito_code = DB::table('distritos')->where([
                'name'          => $data->ubi_dir_dist_desc,
                'provincia_id'  => $provincia_id,
            ])->first()->code;

            return [
                'rut'               => $data->num_doc,
                'nombre'            => $data->nombres,
                'apellido_paterno'  => $data->apellido_paterno,
                'apellido_materno'  => $data->apellido_materno,
                'direccion'         => strtoupper($data->dir_nombre) . ' - ' . $data->ubi_dir_dist_desc,
                'fecha_nacimiento'  => $data->fecha_nacimiento,
                'sexo'              => $data->cod_sexo === '1' ? 'M' : 'F',
                'nacionalidad_id'   => 'PE',
                'email'             => $data->email ?? '',
                'telefono'          => $data->telefono ?? '',
                'estado_civil_id'   => $estado_civil_code,
                'distrito_id'       => $distrito_code,
                'tipo_zona_id'      => '',
                'tipo_via_id'       => '',
                'nombre_zona'       => '',
                'nombre_via'        => '',
                'reniec'            => '1'
            ];
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
